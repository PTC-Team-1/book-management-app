<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

// 2026年11月25日追加: OpenBD APIの応答から書誌情報を取り出す。
class OpenBdLookupService
{
    /**
     * @return array{title: string, author: string, publisher: string, published_date: string, description: string, thumbnail: string}|null
     */
    public function lookup(string $isbn): ?array
    {
        $response = Http::withOptions([
            'proxy' => [
                'http'  => config('services.openbd.proxy'),
                'https' => config('services.openbd.proxy'),
            ],
            'timeout' => config('services.openbd.timeout'),
        ])->get(config('services.openbd.base_url'), [
            'isbn' => $isbn,
        ]);
        $response->throw();

        $record = $response->json('0');
        if (! is_array($record)) {
            return null;
        }

        $summary = $record['summary'] ?? [];
        if (! is_array($summary)) {
            return null;
        }

        $title = $summary['title'] ?? null;
        if (! is_string($title) || trim($title) === '') {
            return null;
        }

        return [
            'title' => trim($title),
            'author' => $this->textValue($summary, 'author'),
            'publisher' => $this->textValue($summary, 'publisher'),
            'published_date' => $this->fullPublishedDate($summary['pubdate'] ?? null),
            'description' => $this->description($record['onix']['CollateralDetail']['TextContent'] ?? []),
            'thumbnail' => $this->thumbnailUrl($summary['cover'] ?? ''),
        ];
    }

    /**
     * @param  array<string, mixed>  $summary
     */
    private function textValue(array $summary, string $key): string
    {
        $value = $summary[$key] ?? '';

        return is_string($value) ? trim($value) : '';
    }

    private function fullPublishedDate(mixed $publishedDate): string
    {
        if (! is_string($publishedDate)) {
            return '';
        }

        if (preg_match('/\A(\d{4})(\d{2})(\d{2})\z/', $publishedDate, $matches)) {
            $publishedDate = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
        }

        if (
            ! preg_match('/\A(\d{4})-(\d{2})-(\d{2})\z/', $publishedDate, $matches)
            || ! checkdate((int) $matches[2], (int) $matches[3], (int) $matches[1])
        ) {
            return '';
        }

        return $publishedDate;
    }

    private function description(mixed $textContents): string
    {
        if (! is_array($textContents)) {
            return '';
        }

        $textContents = array_is_list($textContents) ? $textContents : [$textContents];
        $fallback = '';

        foreach ($textContents as $textContent) {
            if (! is_array($textContent) || ! is_string($textContent['Text'] ?? null)) {
                continue;
            }

            $text = trim($textContent['Text']);
            if ($text === '') {
                continue;
            }

            if (($textContent['TextType'] ?? null) === '02') {
                return $text;
            }

            $fallback = $fallback === '' ? $text : $fallback;
        }

        return $fallback;
    }

    private function thumbnailUrl(mixed $thumbnail): string
    {
        if (! is_string($thumbnail)) {
            return '';
        }

        $thumbnail = preg_replace('/\Ahttp:/i', 'https:', trim($thumbnail)) ?? '';

        if (
            filter_var($thumbnail, FILTER_VALIDATE_URL) === false
            || parse_url($thumbnail, PHP_URL_SCHEME) !== 'https'
        ) {
            return '';
        }

        return $thumbnail;
    }
}
