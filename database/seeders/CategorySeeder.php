<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name_en' => 'English',
                'name_ar' => 'الإنجليزية',
            ],
            [
                'name_en' => 'Math',
                'name_ar' => 'الرياضيات',
            ],
            [
                'name_en' => 'Biology',
                'name_ar' => 'علم الأحياء',
            ],
            [
                'name_en' => 'Science',
                'name_ar' => 'العلوم',
            ],
        ]);
    }
}
