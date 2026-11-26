<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $statusIds = DB::table('rental_statuses')->pluck('id', 'code');

        if (!isset($statusIds['available'])) {
            throw new RuntimeException('rental_statuses に code="available" のレコードが見つかりません。先に RentalStatusSeeder を実行してください。');
        }

        $categoryIds = DB::table('categories')->pluck('id', 'name');

        if (!isset($categoryIds['小説'])) {
            throw new RuntimeException('categories に name="小説" のレコードが見つかりません。先に CategorySeeder を実行してください。');
        }

        $books = [
            [
                'title' => '吾輩は猫である',
                'author' => '夏目漱石',
                'publisher' => '岩波書店',
                'isbn' => '9784003101018',
                'published_date' => '1905-10-06',
                'description' => '猫の視点から人間社会を描いた夏目漱石の代表作。',
                'thumbnail' => null,
                'status_code' => 'available',
                'category_name' => '小説',
            ],
            [
                'title' => 'こころ',
                'author' => '夏目漱石',
                'publisher' => '岩波書店',
                'isbn' => '9784003101117',
                'published_date' => '1914-09-20',
                'description' => '人間の孤独や罪悪感を描いた小説。',
                'thumbnail' => null,
                'status_code' => 'available',
                'category_name' => '小説',
            ],
            [
                'title' => '人間失格',
                'author' => '太宰治',
                'publisher' => '新潮社',
                'isbn' => '9784101006055',
                'published_date' => '1948-07-25',
                'description' => '主人公の人生を通して人間の内面を描いた作品。',
                'thumbnail' => null,
                'status_code' => 'available',
                'category_name' => '小説',
            ],
            [
                'title' => '走れメロス',
                'author' => '太宰治',
                'publisher' => '新潮社',
                'isbn' => '9784101006062',
                'published_date' => '1940-05-01',
                'description' => '友情と信頼をテーマにした短編小説。',
                'thumbnail' => null,
                'status_code' => 'available',
                'category_name' => '小説',
            ],
            [
                'title' => '羅生門',
                'author' => '芥川龍之介',
                'publisher' => '新潮社',
                'isbn' => '9784101025019',
                'published_date' => '1915-11-01',
                'description' => '極限状態に置かれた人間の心理を描いた短編小説。',
                'thumbnail' => null,
                'status_code' => 'available',
                'category_name' => '小説',
            ],
        ];

        $now = now();

        foreach ($books as $book) {
            $statusCode = $book['status_code'] ?? 'available';
            $rentalStatusId = $statusIds[$statusCode] ?? $statusIds['available'];

            $categoryName = $book['category_name'] ?? '小説';
            $categoryId = $categoryIds[$categoryName] ?? $categoryIds['小説'];

            unset($book['status_code'], $book['category_name']);

            DB::table('books')->updateOrInsert(
                ['title' => $book['title']],
                array_merge($book, [
                    'rental_status_id' => $rentalStatusId,
                    'category_id' => $categoryId,
                    'updated_at' => $now,
                    'created_at' => $now,
                ])
            );
        }
    }
}
