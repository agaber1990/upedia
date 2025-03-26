<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Level;
use App\Models\TrackType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TracksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tracks')->truncate();


        $categories = Category::all();
        $levels = Level::all();
        $track_types = TrackType::all();

        if ($categories->isEmpty() || $levels->isEmpty() || $track_types->isEmpty()) {
            throw new \Exception('no data founds in the tables');
        }


        $tracks = [];

        for ($i = 1; $i <= 5; $i++) {
            $tracks[] = [
                'cat_id' => $categories->random()->id,
                'track_name_en' => 'Track English ' . $i,
                'track_name_ar' => 'Track Arabic ' . $i,
                'level_number' => $levels->random()->id,
                'session' => random_int(1, 8),
                'schedule' => ($i % 2 == 0) ? 'once' : 'twice',
                'valid_for' => json_encode($track_types->random(rand(1, 3))->pluck('id')->toArray()),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tracks')->insert($tracks);
    }
}
