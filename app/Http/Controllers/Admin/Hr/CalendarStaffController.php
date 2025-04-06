<?php

namespace App\Http\Controllers\Admin\Hr;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\EmType;
use App\Models\SlotEmp;
use App\Models\TrackAssignedStaff;
use App\Models\StaffScheduled;
use App\Models\StaffSlot;
use App\Models\Track;
use App\Models\TrackType;
use App\SmStaff;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class CalendarStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Fetch the necessary data with the staff_slots relationship
            $slot_time = SlotEmp::get(); // Eager load staffSlots

            // $staffSlots = StaffSlot::where("staff_id", $slot_time->id)
            $track_types = TrackType::all();
            $tracks = Track::all();
            $role_types = EmType::all();
            $categories = Category::all();
            $specializations_staff = TrackAssignedStaff::get();
            // Format the events for FullCalendar
            $events = $slot_time->map(function ($slot) {
                return [
                    'title' => 'Available',
                    'start' => $slot->slot_start,
                    'end' => $slot->slot_end,
                    'color' => 'green'
                ];
            });



            // Pass the formatted events to the view
            return view('backEnd.humanResource.calendar.index', compact(
                'events',
                'track_types',
                'tracks',
                'role_types',
                'categories',
                'specializations_staff'
            ));
        } catch (\Exception $e) {
            // Handle error
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    // AJAX function to fetch staff based on the selected track
    public function getStaffByTrack(Request $request)
    {
        // Get the selected track ID and track type ID from the request
        $track_id = $request->track_id;
        $track = Track::find($track_id);
        // Validate that both track_id and track_type_id are provided
        if (empty($track_id)) {
            return response()->json(['error' => 'Track ID and Track Type ID are required'], 400);
        }

        // Filter the staff based on the selected track and track type, and eager load staff details
        $staff = TrackAssignedStaff::where('track_id', $track_id)
            ->with(['staff:id,full_name']) // Eager load only the staff id and full_name
            ->get();

        // Check if staff are found for the given track and track type
        if ($staff->isEmpty()) {
            return response()->json(['message' => 'No staff found for the selected track and type'], 404);
        }

        // Map the results to return only the required fields (staff_id and full_name)
        $staffNamesAndIds = $staff->map(function ($staffMember) {
            return [
                'id' => $staffMember->id,
                'track_id' => $staffMember->track_id,
                'track_type_id' => $staffMember->track_type_id,
                'staff_id' => $staffMember->staff->id,  // Staff ID
                'staff_name' => $staffMember->staff->full_name,  // Staff full name
            ];
        });

        // Include the track details in the response
        return response()->json([
            'track' => [
                'cat_id' => $track->cat_id,
                'track_name_en' => $track->track_name_en, // Assuming the track has a "name" field
                'track_name_ar' => $track->track_name_ar ?? null, // Optional description field
                'level_number' => $track->level_number ?? null, // Optional description field
                'length' => $track->length ?? null, // Optional description field
                'session' => $track->session ?? null, // Optional description field
                'schedule' => $track->schedule ?? null, // Optional description field
                'valid_for' => $track->valid_for ?? null, // Optional description field
            ],
            'staff' => $staffNamesAndIds,
        ]);
    }



    public function getSlotsByStaff(Request $request)
    {
        // Validate staff_id
        $validated = $request->validate([
            'staff_id' => 'required|integer',
        ]);

        $staff_id = $validated['staff_id'];

        // Fetch the staff member
        $staff = SmStaff::find($staff_id);

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        // Fetch the slot_ids associated with the staff_id
        $slots = StaffSlot::where('staff_id', $staff_id)->pluck('slot_id');

        if ($slots->isEmpty()) {
            return response()->json(['error' => 'No slots found for the staff'], 404);
        }

        // Fetch slot details
        $slotDetails = SlotEmp::whereIn('id', $slots)
            ->select("id", "slot_day", "slot_start", "slot_end")
            ->get()
            ->map(function ($slot) use ($staff_id) {
                // Fetch scheduled slots for the staff
                $staff_scheduleds = StaffScheduled::where('staff_id', $staff_id)->get();

                if ($staff_scheduleds->isEmpty()) {
                    // Default status is 'available' if no schedules exist
                    $slot->status = 'available';
                } else {
                    // Check if the slot is scheduled
                    $isScheduled = false;
                    foreach ($staff_scheduleds as $item) {
                        $scheduled_ids = json_decode($item->slot_id, true);
                        if (in_array($slot->id, $scheduled_ids)) {
                            $isScheduled = true;
                            $slot->status = $item->status;
                            break;
                        }
                    }

                    if (!$isScheduled) {
                        $slot->status = 'available';
                    }
                }

                return $slot;
            });

        // Return response with staff and slot details
        return response()->json([
            'slots' => $slotDetails,
        ]);
    }
    public function getSlotsByStaffReport(Request $request)
    {
        // Validate staff_id
        $validated = $request->validate([
            'staff_id' => 'required|integer',
        ]);

        $staff_id = $validated['staff_id'];

        // Fetch the staff member
        $staff = SmStaff::find($staff_id);

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        // Fetch the slot_ids associated with the staff_id
        $slots = StaffSlot::where('staff_id', $staff_id)->pluck('slot_id');

        if ($slots->isEmpty()) {
            return response()->json(['error' => 'No slots found for the staff'], 404);
        }

        // Fetch slot details
        $slotDetails = SlotEmp::whereIn('id', $slots)
            ->select("id", "slot_day", "slot_start", "slot_end")
            ->get()
            ->map(function ($slot) use ($staff_id) {
                // Fetch scheduled slots for the staff
                $staff_scheduleds = StaffScheduled::where('staff_id', $staff_id)->get();

                if ($staff_scheduleds->isEmpty()) {
                    // Default status is 'available' if no schedules exist
                    $slot->status = 'available';
                } else {
                    // Check if the slot is scheduled
                    $isScheduled = false;
                    foreach ($staff_scheduleds as $item) {
                        $scheduled_ids = json_decode($item->slot_id, true);
                        if (in_array($slot->id, $scheduled_ids)) {
                            $isScheduled = true;
                            $slot->status = $item->status;
                            $slot->start_date = $item->start_date;
                            $slot->end_date = $item->end_date;
                            break;
                        }
                    }

                    if (!$isScheduled) {
                        $slot->status = 'available';
                    }
                }

                return $slot;
            });

        // Return response with staff and slot details
        return response()->json([
            'slots' => $slotDetails,
        ]);
    }


    public function scheduleStaffEvent(Request $request)
    {
        $schedule = null;
        if (isset($request->staff_scheduled_id)) {
            $schedule = StaffScheduled::find($request->staff_scheduled_id);
        }

        // Validate incoming data
        $validated = $request->validate([
            'course_name_en' => 'required|string',
            'course_name_ar' => 'required|string',
            'selected_slots' => 'required|array',
            'cat_id' => 'required|exists:categories,id',
            'staff_id' => 'required|exists:sm_staffs,id',
            'track_id' => 'required|integer',
            'track_type_id' => 'required|integer',
            'session' => 'required|integer',
            'schedule' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $staffId = $validated['staff_id'];
        $selectedSlots = $validated['selected_slots'];
        $newStartDate = $validated['start_date'];
        $newEndDate = $validated['end_date'];

        // Remove duplicates from selected_slots
        $selectedSlots = array_unique($selectedSlots);

        // Check for overlapping schedules for the same teacher and slots
        $existingSchedules = StaffScheduled::where('staff_id', $staffId)
            ->where('status', 'scheduled')
            ->get();

        $hasOverlap = false;
        $overlappingSchedule = null;

        foreach ($selectedSlots as $slotId) {
            foreach ($existingSchedules as $existingSchedule) {
                // Check if the slot is part of the existing schedule
                $scheduledSlots = json_decode($existingSchedule->slot_id, true);
                if (in_array($slotId, $scheduledSlots)) {
                    // Check for date overlap
                    $existingStartDate = $existingSchedule->start_date;
                    $existingEndDate = $existingSchedule->end_date;

                    // Check if the new date range overlaps with the existing date range
                    // Two ranges overlap if: (StartA <= EndB) and (EndA >= StartB)
                    if ($newStartDate <= $existingEndDate && $newEndDate >= $existingStartDate) {
                        $hasOverlap = true;
                        $overlappingSchedule = $existingSchedule;
                        break 2; // Break out of both loops
                    }
                }
            }
        }

        // If there's an overlap, return an error
        if ($hasOverlap) {
            return response()->json([
                'error' => 'The selected dates overlap with an existing schedule for this teacher.',
                'existing_start_date' => $overlappingSchedule->start_date,
                'existing_end_date' => $overlappingSchedule->end_date,
            ], 400);
        }

        // If no overlap, proceed with saving the schedule
        if ($schedule) {
            // Update the existing record
            $schedule->update([
                'course_name_en' => $validated['course_name_en'],
                'course_name_ar' => $validated['course_name_ar'],
                'slot_id' => json_encode($selectedSlots),
                'cat_id' => $validated['cat_id'],
                'staff_id' => $validated['staff_id'],
                'track_type_id' => $validated['track_type_id'],
                'track_id' => $validated['track_id'],
                'status' => 'scheduled',
                'session' => $validated['session'],
                'schedule' => $validated['schedule'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

            $message = "Staff Scheduled event updated successfully.";
        } else {
            // Create a new record
            StaffScheduled::create([
                'course_name_en' => $validated['course_name_en'],
                'course_name_ar' => $validated['course_name_ar'],
                'slot_id' => json_encode($selectedSlots),
                'cat_id' => $validated['cat_id'],
                'staff_id' => $validated['staff_id'],
                'track_type_id' => $validated['track_type_id'],
                'track_id' => $validated['track_id'],
                'status' => 'scheduled',
                'session' => $validated['session'],
                'schedule' => $validated['schedule'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

            $message = "Staff Scheduled event created successfully.";
        }

        // Return a response with success
        return response()->json([
            'success' => $message,
        ], 200);
    }




    public function calendar_report(Request $request)
    {
        try {
            // Fetch the necessary data with the staff_slots relationship
            $slot_time = SlotEmp::get(); // Eager load staffSlots

            // $staffSlots = StaffSlot::where("staff_id", $slot_time->id)
            $track_types = TrackType::all();
            $tracks = Track::all();
            $role_types = EmType::all();
            $categories = Category::all();
            $specializations_staff = TrackAssignedStaff::get();
            // Format the events for FullCalendar
            $events = $slot_time->map(function ($slot) {
                return [
                    'title' => 'Available',
                    'start' => $slot->slot_start,
                    'end' => $slot->slot_end,
                    'color' => 'green'
                ];
            });



            // Pass the formatted events to the view
            return view('backEnd.humanResource.calendar.calendarReport', compact(
                'events',
                'track_types',
                'tracks',
                'role_types',
                'categories',
                'specializations_staff'
            ));
        } catch (\Exception $e) {
            // Handle error
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function getTeachersByTime(Request $request)
    {
        $day = $request->input('day');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $trackId = $request->input('track_id');
        $schedule = $request->input('schedule');

        // Log the received inputs
        Log::info("Step 1 - Received Inputs: Day: $day, Start: $startTime, End: $endTime, Track: $trackId, Schedule: $schedule");

        // Normalize the time format (remove seconds if present, ensure HH:MM format)
        $startTime = date('H:i', strtotime($startTime));
        $endTime = date('H:i', strtotime($endTime));

        // Log the normalized times
        Log::info("Step 2 - Normalized Times: Start: $startTime, End: $endTime");

        // Find slots that overlap with the selected time range
        $query = SlotEmp::where('slot_day', $day)
            ->whereRaw("TIME_FORMAT(slot_end, '%H:%i') > ?", [$startTime])
            ->whereRaw("TIME_FORMAT(slot_start, '%H:%i') < ?", [$endTime]);

        $foundDays = $query->select('id', 'slot_day', 'slot_start', 'slot_end')
            ->get();

        // Log the found slots
        Log::info("Step 3 - Found Slots: " . $foundDays->toJson());

        // If no slots match the criteria, return an empty response
        if ($foundDays->isEmpty()) {
            Log::info("Step 4 - No slots found matching the criteria.");
            return response()->json(['teachers' => []]);
        }

        $slotIds = $foundDays->pluck('id')->toArray();

        // Log the slot IDs
        Log::info("Step 5 - Slot IDs: " . json_encode($slotIds));

        // Find staff associated with these slots
        $staffSlots = StaffSlot::whereIn('slot_id', $slotIds)->get();
        $staffIds = $staffSlots->pluck('staff_id')->toArray();

        // Log the staff IDs
        Log::info("Step 6 - Staff IDs: " . json_encode($staffIds));

        // If no staff are associated with these slots, return an empty response
        if (empty($staffIds)) {
            Log::info("Step 7 - No staff found for the matching slots.");
            return response()->json(['teachers' => []]);
        }

        // Fetch teachers who have the matching slots
        $teachers = SmStaff::whereIn('id', $staffIds)
            ->with(['slots' => function ($query) use ($slotIds) {
                $query->whereIn('slot_id', $slotIds);
            }, 'slots.slotEmp'])
            ->select('id', 'full_name')
            ->get();

        // Log the teachers before filtering
        Log::info("Step 8 - Teachers before filtering: " . $teachers->toJson());

        // Filter teachers to ensure they cover the entire time range
        $filteredTeachers = $teachers->filter(function ($teacher) use ($day, $startTime, $endTime, $schedule) {
            // Filter slots that overlap with the selected time range
            $teacherSlots = $teacher->slots->filter(function ($slot) use ($day, $startTime, $endTime, $teacher) {
                $slotStart = date('H:i', strtotime($slot->slotEmp->slot_start));
                $slotEnd = date('H:i', strtotime($slot->slotEmp->slot_end));
                $overlap = $slot->slotEmp->slot_day === $day &&
                    $slotEnd > $startTime &&
                    $slotStart < $endTime;

                Log::info("Step 9 - Checking slot for teacher ID: {$teacher->id}, Slot: {$slot->id}, Day: {$slot->slotEmp->slot_day}, Start: $slotStart, End: $slotEnd, Overlap: " . ($overlap ? 'true' : 'false'));

                return $overlap;
            });

            // If no slots overlap, exclude the teacher
            if ($teacherSlots->isEmpty()) {
                Log::info("Step 10 - No overlapping slots for teacher ID: {$teacher->id}");
                return false;
            }

            // Log the overlapping slots for this teacher
            Log::info("Step 11 - Overlapping slots for teacher ID: {$teacher->id}: " . $teacherSlots->toJson());

            // Check for exact match first
            $hasExactMatch = $teacherSlots->contains(function ($slot) use ($startTime, $endTime) {
                $slotStart = date('H:i', strtotime($slot->slotEmp->slot_start));
                $slotEnd = date('H:i', strtotime($slot->slotEmp->slot_end));
                $exactMatch = $slotStart === $startTime && $slotEnd === $endTime;

                Log::info("Step 12 - Checking exact match for slot ID: {$slot->id}, Slot Start: $slotStart, Slot End: $slotEnd, Exact Match: " . ($exactMatch ? 'true' : 'false'));

                return $exactMatch;
            });

            if ($hasExactMatch) {
                Log::info("Step 13 - Exact match found for teacher ID: {$teacher->id}, skipping coverage check.");
                return true; // If there's an exact match, no need to check coverage
            }

            // If no exact match, check if the slots cover the entire time range
            $startMinutes = (int)date('H', strtotime($startTime)) * 60 + (int)date('i', strtotime($startTime));
            $endMinutes = (int)date('H', strtotime($endTime)) * 60 + (int)date('i', strtotime($endTime));

            Log::info("Step 14 - Time range for teacher ID: {$teacher->id}, Start Minutes: $startMinutes, End Minutes: $endMinutes");

            // Create an array to track covered minutes
            $coveredMinutes = array_fill(0, $endMinutes - $startMinutes, false);

            // Mark the minutes covered by each slot
            foreach ($teacherSlots as $slot) {
                $slotStart = date('H:i', strtotime($slot->slotEmp->slot_start));
                $slotEnd = date('H:i', strtotime($slot->slotEmp->slot_end));
                $slotStartMinutes = (int)date('H', strtotime($slotStart)) * 60 + (int)date('i', strtotime($slotStart));
                $slotEndMinutes = (int)date('H', strtotime($slotEnd)) * 60 + (int)date('i', strtotime($slotEnd));

                Log::info("Step 15 - Processing slot ID: {$slot->id} for teacher ID: {$teacher->id}, Slot Start Minutes: $slotStartMinutes, Slot End Minutes: $slotEndMinutes");

                // Adjust the start and end minutes to the overlapping part
                $effectiveStartMinutes = max($slotStartMinutes, $startMinutes);
                $effectiveEndMinutes = min($slotEndMinutes, $endMinutes);

                Log::info("Step 16 - Effective range for slot ID: {$slot->id}, Effective Start Minutes: $effectiveStartMinutes, Effective End Minutes: $effectiveEndMinutes");

                // Include the last minute by using <=
                for ($i = $effectiveStartMinutes; $i <= $effectiveEndMinutes; $i++) {
                    $index = $i - $startMinutes;
                    if ($index >= 0 && $index < ($endMinutes - $startMinutes)) {
                        $coveredMinutes[$index] = true;
                        Log::info("Step 17 - Marking minute $i as covered for teacher ID: {$teacher->id}, Slot ID: {$slot->id}, Index: $index");
                    }
                }
            }

            // Check if all minutes in the range are covered
            $allCovered = !in_array(false, $coveredMinutes, true);

            // Log the coverage result
            Log::info("Step 18 - Coverage result for teacher ID: {$teacher->id}, All minutes covered: " . ($allCovered ? 'true' : 'false'));

            // Log the uncovered minutes (if any)
            $uncoveredMinutes = [];
            foreach ($coveredMinutes as $index => $isCovered) {
                if (!$isCovered) {
                    $minute = $startMinutes + $index;
                    if ($minute < $endMinutes) { // Ensure we don't go beyond the end time
                        $hour = floor($minute / 60);
                        $min = $minute % 60;
                        $uncoveredMinutes[] = sprintf("%02d:%02d", $hour, $min);
                    }
                }
            }
            if (!empty($uncoveredMinutes)) {
                Log::info("Step 19 - Uncovered minutes for teacher ID: {$teacher->id}: " . json_encode($uncoveredMinutes));
            }

            return $allCovered;
        });

        // Log the filtered teachers
        Log::info("Step 20 - Filtered Teachers: " . $filteredTeachers->toJson());

        // Add availability status for each slot
        $filteredTeachers->each(function ($teacher) use ($day, $startTime, $endTime) {
            $teacher->slots = $teacher->slots->filter(function ($slot) use ($day, $startTime, $endTime) {
                $slotStart = date('H:i', strtotime($slot->slotEmp->slot_start));
                $slotEnd = date('H:i', strtotime($slot->slotEmp->slot_end));
                return $slot->slotEmp->slot_day === $day &&
                    $slotEnd > $startTime &&
                    $slotStart < $endTime;
            })->values();

            $teacher->slots->each(function ($slot) use ($teacher) {
                // Check if the slot is scheduled in StaffScheduled
                $staffScheduled = StaffScheduled::where('staff_id', $teacher->id)
                    ->whereJsonContains('slot_id', (string)$slot->slot_id)
                    ->select('status', 'start_date', 'end_date')
                    ->get(); // Use get() to fetch all schedules, not just the first one

                if ($staffScheduled->isNotEmpty()) {
                    // If there are scheduled periods, collect all periods
                    $scheduledPeriods = $staffScheduled->map(function ($schedule) {
                        return [
                            'status' => $schedule->status,
                            'start_date' => $schedule->start_date,
                            'end_date' => $schedule->end_date,
                        ];
                    })->toArray();

                    $slot->status = 'scheduled'; // Mark as scheduled if there are any schedules
                    $slot->scheduled_periods = $scheduledPeriods; // Add all scheduled periods
                } else {
                    $slot->status = 'available'; // Default to available if not scheduled
                    $slot->scheduled_periods = []; // No scheduled periods
                }

                Log::info("Step 21 - Slot status for teacher ID: {$teacher->id}, Slot ID: {$slot->id}, Status: {$slot->status}, Scheduled Periods: " . json_encode($slot->scheduled_periods));
            });
        });

        // Log the final response
        Log::info("Step 22 - Final Response: " . json_encode(['teachers' => $filteredTeachers->values()]));

        return response()->json(['teachers' => $filteredTeachers->values()]);
    }
}
