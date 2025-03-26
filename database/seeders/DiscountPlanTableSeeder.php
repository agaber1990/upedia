<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discount_plans')->truncate();
        $levels = Level::all();


        $discount_plans = [];
        for ($i = 1; $i <= 10; $i++) {

            $selected_levels = $levels->random(rand(1, 3));

            $levels_prices = $selected_levels->map(function ($level) {
                return [
                    'level_id' => $level->id,
                    'price' => rand(30, 90),
                ];
            })->toArray();



            $discount_plans[] = [
                'name_en' => 'Name English ' . $i,
                'name_ar' => 'Name Arabic ' . $i,
                'levels_prices' => json_encode($levels_prices),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert discount_plans into the table
        DB::table('discount_plans')->insert($discount_plans);
    }
}
