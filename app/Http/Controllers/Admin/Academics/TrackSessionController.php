<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\TrackSession;
use Illuminate\Support\Facades\Validator;

class TrackSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $track_id)
    {

        $track = Track::where('id', $track_id)->first();
        $sessions = TrackSession::where('id', $track->id)->with('track')->get();
        $menus = TrackSession::where('track_id', $track->id)->with('track', 'level')->get();
        $levels = Level::where('id', '<=', $track->level_number)->get();

        $groupedMenus = $menus->groupBy('level_id');

        return view('backEnd.academics.sessions.index', compact('track', 'sessions', 'menus', 'levels', 'groupedMenus'));
    }


    public function fetchJsonData($track_id)
    {
        $track = Track::where('id', $track_id)->first();
        $sessions = TrackSession::where('track_id', $track->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Session deleted successfully.',
            'sessions' => $sessions
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'track_id' => 'required|exists:tracks,id',
                'level_id' => 'required|exists:levels,id',
                'session_name_en' => 'required|string',
                'session_name_ar' => 'required|string',
            ]);
            $existingSessionsCount = 0;
            // Fetch the track and its existing sessions
            $track = Track::findOrFail($validated['track_id']);
            $trackSessions = TrackSession::where('track_id', $validated['track_id'])->get();
            $existingSessionsCount = count($trackSessions);

            if ($existingSessionsCount >= $track->session) {
                return response()->json(['error' => 'Sorry, you cannot add more sessions.'], 422);
            }

            // Create the track session
            TrackSession::create([
                'track_id' => $validated['track_id'],
                'level_id' => $validated['level_id'],
                'session_number' => $existingSessionsCount + 1,
                'session_name_en' => $validated['session_name_en'],
                'session_name_ar' => $validated['session_name_ar'],
                'session_ref' => "TRS" . time()
            ]);


            return response()->json([
                'message' => 'Track session added successfully.',
                'data' => $trackSessions
            ], 200);
            Toastr::success('Created successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TrackSession $trackSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrackSession $trackSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'session_name_en' => 'required|string|max:255',
            'session_name_ar' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
        ]);

        $session = TrackSession::findOrFail($id);

        $session->update([
            'session_name_en' => $request->session_name_en,
            'session_name_ar' => $request->session_name_ar,
            'level_id' => $request->level_id,
        ]);

        return response()->json(['message' => 'Session updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $session = TrackSession::findOrFail($id);
        $session->delete();
    }
}
