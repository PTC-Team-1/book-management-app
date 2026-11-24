<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            [
                'email' => 'yamada@example.com',
                'book_title' => '吾輩は猫である',
                'content' => '独特な視点で描かれていて面白かったです。',
                'rating' => 5,
            ],
            [
                'email' => 'sato@example.com',
                'book_title' => '吾輩は猫である',
                'content' => '文章が読みやすく、楽しく読めました。',
                'rating' => 4,
            ],
            [
                'email' => 'yamada@example.com',
                'book_title' => 'こころ',
                'content' => '登場人物の心理描写が印象的でした。',
                'rating' => 3,
            ],
            [
                'email' => 'sato@example.com',
                'book_title' => '人間失格',
                'content' => '考えさせられる内容でした。',
                'rating' => 1,
            ],
            [
                'email' => 'sato@example.com',
                'book_title' => '羅生門',
                'content' => '人間の心理について深く考えさせられました。',
                'rating' => 2,
            ],
        ];

        foreach ($comments as $comment) {
            $userId = $comment['email']
                ? DB::table('users')
                ->where('email', $comment['email'])
                ->value('id')
                : null;

            $bookId = DB::table('books')
                ->where('title', $comment['book_title'])
                ->value('id');

            if (!$bookId) {
                continue;
            }

            DB::table('comments')->updateOrInsert(
                [
                    'book_id' => $bookId,
                    'user_id' => $userId,
                    'content' => $comment['content'],
                    'rating' => $comment['rating'],
                ],
                [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
