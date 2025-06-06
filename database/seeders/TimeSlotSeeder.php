<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [ 'Saturday','Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        $timeSlots = [];

        foreach ($days as $day) {
            for ($hour = 10; $hour < 24; $hour++) {
                // Generate start and end times for each hour
                $startTime = sprintf('%02d:00:00', $hour); // E.g., "00:00:00"
                $endTime = sprintf('%02d:00:00', ($hour + 1) % 24); // E.g., "01:00:00", wrapping to "00:00:00" at midnight

                $teacherTimeSlots[] = [
                    'slot_day' => $day,
                    'slot_start' => $startTime,
                    'slot_end' => $endTime,
                    'type'=>'teacher'
                ];
                $testerTimeSlots[] = [
                    'slot_day' => $day,
                    'slot_start' => $startTime,
                    'slot_end' => $endTime,
                    'type'=>'tester'
                ];
            }
        }

        // Insert the time slots into the database
        DB::table('slot_emps')->insert(array_merge($teacherTimeSlots, $testerTimeSlots));

    }
}
