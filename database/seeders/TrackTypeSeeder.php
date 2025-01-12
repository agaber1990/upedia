<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('track_types')->insert([
            ['name' => 'Native'],
            ['name' => 'Private'],
            ['name' => 'Semi-Private'],
            ['name' => 'Group'],
        ]);
    }
}
