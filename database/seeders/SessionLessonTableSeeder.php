<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\TrackLevel;
use App\Models\TrackSessionLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionLessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('session_lessons')->truncate();
        $levels = TrackLevel::all();
        $sessions = TrackSessionLevel::all();
        if ($levels->isEmpty() || $sessions->isEmpty()) {
            throw new \Exception('no data founds in the tables');
        }

        $sessionLessons = [];
        $privacyOptions = ['locked', 'unlocked'];
        $hostTypeOptions = ['image', 'youtube', 'video', 'pdf', 'word', 'excel'];

        for ($i = 1; $i <= 5; $i++) {
            $session = $sessions->random();

            $level_id = $session->level_id;

            $sessionLessons[] = [
                'session_id' => $session->id,
                'level_id' => $level_id,
                'name' => 'Lesson Session ' . $i,
                'duration' => '00:' . sprintf('%02d', rand(30, 90)) . ':00',
                'privacy' => $privacyOptions[array_rand($privacyOptions)],
                'host_type' => $hostTypeOptions[array_rand($hostTypeOptions)],
                'host_path' => 'path/to/lesson_' . $i . '.file',
                'description' => 'Description for Lesson Session ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('session_lessons')->insert($sessionLessons);
    }
}
