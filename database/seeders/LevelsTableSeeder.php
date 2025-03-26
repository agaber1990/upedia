<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->truncate();
        $levels = [];
        for ($i = 1; $i <= 10; $i++) {
            $levels[] = [
                'level_number' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('levels')->insert($levels);
    }
}
