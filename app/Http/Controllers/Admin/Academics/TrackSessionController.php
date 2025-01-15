<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TrackSessionRequest;
use App\Models\Track;
use App\Models\TrackSession;

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
    public function store(TrackSessionRequest $request)
    {

        $tracksessionCount = TrackSession::find($request->tack_id);
        dd($tracksessionCount);
        TrackSession::create($request->all());

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
