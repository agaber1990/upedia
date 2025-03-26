<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\TrackLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackSessionLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('track_session_levels')->truncate();
        $tracks = Track::all();
        $levels = TrackLevel::all();
        if ($tracks->isEmpty() || $levels->isEmpty()) {
            throw new \Exception('no data founds in the tables');
        }
       
        for ($i = 1; $i <= 5; $i++) {
            $level = $levels->random();
            $track_id = $level->track_id;
            $trackSessionLevels[] = [
                'track_id' => $track_id, 
                'level_id' => $level->id,
                'name_en' => 'Track Session Level English ' . $i,
                'name_ar' => 'Track Session Level Arabic ' . $i,
                'description_en' => 'Track Session Level Description English ' . $i,
                'description_ar' => 'Track Session Level Description Arabic ' . $i,
                'file' => json_encode('Track Level File' . $i),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('track_session_levels')->insert($trackSessionLevels);
    }
}
