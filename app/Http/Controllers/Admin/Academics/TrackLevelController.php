<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Track;
use Illuminate\Http\Request;


use App\Models\TrackLevel;
use App\Models\TrackSession;

class TrackLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $track_id)
    {

        $track = Track::where('id', $track_id)->first();
        $levels = TrackSession::where('id', $track->id)->with('track')->get();
        $menus = TrackSession::where('track_id', $track->id)->with('track', 'level')->get();
        $levels = Level::where('id', '<=', $track->level_number)->get();


        return view('backEnd.academics.track_levels.index', compact('track', 'levels', 'menus', 'levels',));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TrackLevel $trackLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrackLevel $trackLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrackLevel $trackLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrackLevel $trackLevel)
    {
        //
    }
}
