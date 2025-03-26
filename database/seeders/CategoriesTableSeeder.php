<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = [
                'name_en' =>'Category English '. $i,
                'name_ar' =>'Category Arabic '. $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
