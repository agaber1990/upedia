<?php

namespace App\Http\Controllers\Admin\Hr;
use App\Http\Controllers\Controller;

use App\ApiBaseMethod;
use App\Models\CalendarStaff;
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
        // Validate staff_id and optional date
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

        // Fetch slot details and include their statuses for the specific date
        $slotDetails = SlotEmp::whereIn('id', $slots)
            ->select("id", "slot_day", "slot_start", "slot_end")
            ->get()
            ->map(function ($slot) use ($staff_id) {
                $staff_scheduleds = StaffScheduled::where('staff_id', $staff_id)
                    ->get();
                 // loop for every one here 
                 foreach ($staff_scheduleds as $item) {
                     $scheduled_ids = json_decode($item->slot_id, true);

                    # code...
                    $isScheduled = in_array($slot->id, $scheduled_ids);
                    $slot->status = $isScheduled ? $item->status : 'available';
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
        // Validate incoming data
        $validated = $request->validate([
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
        // Create the scheduled event (now using JSON array for slot_id)
        StaffScheduled::create([
            'slot_id' => json_encode($validated['selected_slots']), // Save as JSON
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
    
        // Return a response with success
        return response()->json([
            'success' => "Staff Assigned slots successfully",
        ], 200);
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
