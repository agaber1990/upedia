<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('em_types')->insert([
            [
                'title' => 'Freelancer',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
                'is_saas' => 0,
            ],
            [
                'title' => 'Part-time',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
                'is_saas' => 0,
            ],
            [
                'title' => 'Full-time',
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'school_id' => 1,
                'is_saas' => 0,
            ],
        ]);
    }
}
