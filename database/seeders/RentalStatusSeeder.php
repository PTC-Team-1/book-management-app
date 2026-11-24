<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $statuses = [
            [
                'code' => 'available',
                'name' => '貸出可能',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'rented',
                'name' => '貸出中',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('rental_statuses')->upsert(
            $statuses,
            ['code'],
            ['name', 'updated_at']
        );
    }
}
