<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [];

        // Create levels from 1 to 30
        for ($i = 1; $i <= 30; $i++) {
            $levels[] = [
                'level_number' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert levels into the table
        DB::table('levels')->insert($levels);
    }
}
