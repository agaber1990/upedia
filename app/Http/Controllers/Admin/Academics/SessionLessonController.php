<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionLessonRequest;
use App\Models\SessionLesson;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SessionLessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function store(SessionLessonRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($validated['host_type'] === 'youtube') {
                $filePath = $validated['host_path'];
            } elseif ($request->hasFile('host_path')) {
                $file = $request->file('host_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('session_lesson/'), $fileName);
                $filePath = 'session_lesson/' . $fileName;
            } else {
                $filePath = null;
            }

            SessionLesson::create([
                'session_id' => $validated['session_id'],
                'level_id' => $validated['level_id'],
                'name' => $validated['name'],
                'duration' => $validated['duration'],
                'privacy' => $validated['privacy'],
                'host_type' => $validated['host_type'],
                'host_path' => $filePath,
                'description' => $validated['description'],

            ]);

            Toastr::success('Created successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There were validation errors.',
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(SessionLesson $sessionLesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionLesson $sessionLesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionLesson $sessionLesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionLesson $sessionLesson)
    {
        //
    }
}
