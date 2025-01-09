<?php

namespace App\Http\Controllers\Admin\Hr;
use App\Http\Controllers\Controller;

use App\ApiBaseMethod;
use App\Models\CalendarStaff;
use App\Models\Category;
use App\Models\EmType;
use App\Models\SlotEmp;
use App\Models\SpecializationsStaff;
use App\Models\StaffScheduled;
use App\Models\StaffSlot;
use App\Models\Track;
use App\Models\TrackType;
use App\SmStaff;
use Illuminate\Http\Request;

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
            $specializations_staff = SpecializationsStaff::get();
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
        // Get the selected track ID and track type ID
        $track_id = $request->track_id;
        $track_type_id = $request->track_type_id;

        // Filter the staff based on the selected track and track type, and eager load staff details
        $staff = SpecializationsStaff::where('track_id', $track_id)
            ->where('track_type_id', $track_type_id)
            ->with(['staff:id,full_name']) // Eager load only the staff id and full_name
            ->get();

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

        // Return the staff data with only necessary fields
        return response()->json($staffNamesAndIds);
    }
    public function getSlotsByStaff(Request $request)
    {
        // Validate staff_id and optional date
        $validated = $request->validate([
            'staff_id' => 'required|integer',
            'date' => 'nullable|date', // Optional date filter
        ]);
    
        $staff_id = $request->staff_id;
        $date = $request->date ?? now()->toDateString(); // Default to today's date if not provided
    
        $staff = SmStaff::where('id', $staff_id)->first();
    
        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }
    
        // Fetch the slot_ids associated with the staff_id
        $slots = StaffSlot::where('staff_id', $staff_id)->pluck('slot_id');
    
        // Fetch slot details and include their statuses for the specific date
        $slotDetails = SlotEmp::whereIn('id', $slots)
            ->select("id", "slot_day", "slot_start", "slot_end")
            ->get()
            ->map(function ($slot) use ($staff_id, $date) {
                // Get the scheduled event based on slot_id and staff_id
                $scheduled = StaffScheduled::where('slot_id', $slot->id)
                    ->where('staff_id', $staff_id)
                    ->whereDate('fromDate', '<=', $date) // Check if date is after or on fromDate
                    ->whereDate('toDate', '>=', $date) // Check if date is before or on toDate
                    ->first();
    
                // Determine the status based on the schedule
                if ($scheduled) {
                    // Slot has a scheduled event
                    if ($date == $scheduled->fromDate) {
                        $slot->status = 'started'; // The event is just starting
                    } elseif ($date >= $scheduled->fromDate && $date <= $scheduled->toDate) {
                        $slot->status = 'scheduled'; // The event is ongoing
                    } elseif ($date == $scheduled->toDate) {
                        $slot->status = 'ended'; // The event has ended
                    }
                } else {
                    // Slot is available if no schedule matches
                    $slot->status = 'available';
                }
    
                // Attach the date to the slot for frontend reference
                $slot->date = $date;
    
                return $slot;
            });
    
        return response()->json([
            'staff' => $staff,
            'slots' => $slotDetails,
        ]);
    }
    


    public function scheduleStaffEvent(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'slot_id' => 'required', // Assuming staff_slots table has slots
            'staff_id' => 'required', // Assuming staff_slots table has slots
            'fromDate' => 'required',
            'toDate' => 'required',
            'status' => 'required',
        ]);
        $scheduledEvent = StaffScheduled::create([
            'slot_id' => $validated['slot_id'],
            'staff_id' => $validated['staff_id'],
            'fromDate' => $validated['fromDate'],
            'toDate' => $validated['toDate'],
            'status' => $validated['status'],
        ]);

        return response()->json(['success' => true, 'data' => $scheduledEvent], 200);
    }






    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CalendarStaff $calendarStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalendarStaff $calendarStaff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalendarStaff $calendarStaff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalendarStaff $calendarStaff)
    {
        //
    }
}
