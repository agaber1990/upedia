<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


use App\Models\TrackLevel;

class TrackLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $track_id)
    {

        $track = Track::where('id', $track_id)->first();
        $menus = TrackLevel::where('track_id', $track->id)->with('track')->get();


        return view('backEnd.academics.track_levels.index', compact('track',  'menus',));
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
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
        }

        TrackLevel::create([
            'track_id' => $validated['track_id'],
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'],
            'description_ar' => $validated['description_ar'],
            'file' => $filePath ?? 'No File',
        ]);

        Toastr::success('Created successfully', 'Success');
        return redirect()->back();
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
