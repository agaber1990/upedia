<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\TrackLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackSessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('track_sessions')->truncate();
        $tracks = Track::all();
        $levels = TrackLevel::all();
        if ($tracks->isEmpty() || $levels->isEmpty()) {
            throw new \Exception('no data founds in the tables');
        }

        for ($i = 1; $i <= 5; $i++) {
            $level = $levels->random();
            $track_id = $level->track_id;
            $TrackLevelSessions[] = [
                'track_id' => $track_id,
                'level_id' => $level->id,
                'session_name_en' => 'Track Session English ' . $i,
                'session_name_ar' => 'Track Session Arabic ' . $i,
                'session_number' => random_int(1,5),
                'session_ref' => 'Track Session Reference ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('track_sessions')->insert($TrackLevelSessions);
    }
}
