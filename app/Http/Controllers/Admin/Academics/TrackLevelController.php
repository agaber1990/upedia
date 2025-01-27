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



    public function store(Request $request)
    {
        $validated = $request->validate([
            'track_id' => 'required|exists:tracks,id',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $filePath = 'No File';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // 
            $file->move(public_path('courses_student/'), $fileName);
            $filePath = 'courses_student/' . $fileName;
        }

        TrackLevel::create([
            'track_id' => $validated['track_id'],
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'],
            'description_ar' => $validated['description_ar'],
            'file' => $filePath,
        ]);

        Toastr::success('Created successfully', 'Success');
        return redirect()->back();
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'track_id' => 'nullable|exists:tracks,id',
            'name_en' => 'nullable|string',
            'name_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $trackLevel = TrackLevel::findOrFail($request->id);

        if ($request->hasFile('file')) {
            $directory = 'courses_student';

            if ($trackLevel->file && file_exists(public_path($trackLevel->file))) {
                unlink(public_path($trackLevel->file));
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($directory), $fileName);
            $validated['file'] = $directory . '/' . $fileName;
        } else {
            $validated['file'] = $trackLevel->file;
        }

        $trackLevel->update($validated);

        Toastr::success('Updated successfully', 'Success');
        return redirect()->back();
    }


    public function destroy($id)
    {
        $session = TrackLevel::findOrFail($id);
        $session->delete();
    }
}
