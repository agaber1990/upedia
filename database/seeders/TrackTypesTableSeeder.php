<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('track_types')->truncate();

        $track_types = [];
        $names = [
            'Private',
            'Semi-Private',
            'Native',
            'Group',
        ];

        foreach ($names as $name) {
            $count_of_students = $this->getStudentCount($name);

            $track_types[] = [
                'name' => $name,
                'count_of_students' => $count_of_students,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('track_types')->insert($track_types);
    }


    private function getStudentCount(string $trackType): int
    {
        return match ($trackType) {
            'Private' => 1,
            'Semi-Private' => 2,
            'Native' => 3,
            'Group' => 4,
        };
    }
}
