<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\TrackLevel;
use App\Models\TrackLevelSession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionQuizzesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('session_quizzes')->truncate();
        $levels = TrackLevel::all();
        $sessions = TrackLevelSession::all();
        if ($levels->isEmpty() || $sessions->isEmpty()) {
            throw new \Exception('no data founds in the tables');
        }

        $sessionLessons = [];
        $privacyOptions = ['locked', 'unlocked'];

        for ($i = 1; $i <= 5; $i++) {
            $session = $sessions->random();

            $level_id = $session->level_id;

            $sessionLessons[] = [
                'session_id' => $session->id,
                'level_id' => $level_id,
                'title' => 'Session Quiz ' . $i,
                'instruction' => 'Session Instruction ' . $i,
                'min_percentage' => random_int(60, 90),
                'privacy' => $privacyOptions[array_rand($privacyOptions)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('session_quizzes')->insert($sessionLessons);
    }
}
