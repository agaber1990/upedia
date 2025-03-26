<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Level;
use App\Models\Track;
use App\Models\TrackType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('track_levels')->truncate();
        $tracks = Track::all();
        if ($tracks->isEmpty()) {
            throw new \Exception('no data founds in the track table');
        }
        $trackLevels = [];
        for ($i = 1; $i <= 5; $i++) {
            $trackLevels[] = [
                'track_id' => $tracks->random()->id,
                'name_en' => 'Track Level English ' . $i,
                'name_ar' => 'Track Level Arabic ' . $i,
                'description_en' => 'Track Level Description English ' . $i,
                'description_ar' => 'Track Level Description Arabic ' . $i,
                'file' => 'Track Level File' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('track_levels')->insert($trackLevels);
    }
}
