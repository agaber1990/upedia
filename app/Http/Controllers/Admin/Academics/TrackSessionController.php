<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
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

        return view('backEnd.academics.sessions.index', compact('track', 'sessions'));
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
        $validated = $request->validate([
            'track_id' => 'required|exists:tracks,id',
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
            'session_number' => $existingSessionsCount + 1,
            'session_name_en' => $validated['session_name_en'],
            'session_name_ar' => $validated['session_name_ar'],
            'session_ref' => "TRS" . time()
        ]);

        return response()->json([
            'message' => 'Track session added successfully.',
            'data' => $trackSessions
        ], 200);
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
    public function update(Request $request, TrackSession $trackSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrackSession $trackSession)
    {
        //
    }
}
