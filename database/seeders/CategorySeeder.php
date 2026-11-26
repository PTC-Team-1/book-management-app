<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            '小説',
            'ビジネス・経済',
            '技術書・プログラミング',
            'デザイン・アート',
            '歴史・ノンフィクション',
            '自己啓発',
            'コミック・マンガ',
            '雑誌・ムック',
            '資格・試験',
            '洋書',
            '経済・金融',
            'その他',
        ];

        $now = now();

        $rows = array_map(
            fn(string $name) => [
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            $categories
        );

        DB::table('categories')->upsert(
            $rows,
            ['name'],
            ['updated_at']
        );
    }
}
