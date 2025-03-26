<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingPlanTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pricing_plan_types')->truncate();
        DB::table('pricing_plan_types')->insert([
            ['name' => 'B2B'],
            ['name' => 'B2C']
        ]);
    }
}
