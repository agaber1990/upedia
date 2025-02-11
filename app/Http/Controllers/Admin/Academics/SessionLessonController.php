<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionLessonRequest;
use App\Models\SessionLesson;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class SessionLessonController extends Controller
{


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


    // public function update(Request $request, $id)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'name' => 'nullable|string|max:255',
    //             'duration' => 'nullable|integer',
    //             'privacy' => 'nullable|in:locked,unlocked',
    //             'host_type' => 'nullable|in:image,youtube,video,pdf,word,excel',
    //             'host_path' => 'nullable',
    //             'description' => 'nullable|string',
    //         ]);

    //         $lesson = SessionLesson::findOrFail($id);
    //         $filePath = $lesson->host_path;

    //         if (isset($validated['host_type']) && $validated['host_type'] === 'youtube') {
    //             $filePath = $validated['host_path'];
    //         } elseif ($request->hasFile('host_path')) {
    //             if ($lesson->host_path && File::exists(public_path($lesson->host_path))) {
    //                 File::delete(public_path($lesson->host_path));
    //             }

    //             $file = $request->file('host_path');
    //             $fileName = time() . '_' . $file->getClientOriginalName();
    //             $file->move(public_path('session_lesson/'), $fileName);
    //             $filePath = 'session_lesson/' . $fileName;
    //         }

    //         // Update only the fields that are not empty or null
    //         $updateData = [];
    //         if (!empty($validated['name'])) {
    //             $updateData['name'] = $validated['name'];
    //         }
    //         if (!empty($validated['duration'])) {
    //             $updateData['duration'] = $validated['duration'];
    //         }
    //         if (!empty($validated['privacy'])) {
    //             $updateData['privacy'] = $validated['privacy'];
    //         }
    //         if (!empty($validated['host_type'])) {
    //             $updateData['host_type'] = $validated['host_type'];
    //         }
    //         if (!empty($filePath)) {
    //             $updateData['host_path'] = $filePath;
    //         }
    //         if (!empty($validated['description'])) {
    //             $updateData['description'] = $validated['description'];
    //         }

    //         $lesson->update($updateData);

    //         Toastr::success('Updated successfully', 'Success');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         Toastr::error('Operation Failed', 'Failed');
    //         return redirect()->back();
    //     }
    // }



    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'duration' => 'nullable|integer',
                'privacy' => 'nullable|in:locked,unlocked',
                'host_type' => 'nullable|in:image,youtube,video,pdf,word,excel',
                'host_path' => 'nullable',
                'description' => 'nullable|string',
            ]);

            $lesson = SessionLesson::findOrFail($id);
            $filePath = $lesson->host_path;

            if (isset($validated['host_type']) && $validated['host_type'] === 'youtube') {
                $filePath = $validated['host_path'];
            } elseif ($request->hasFile('host_path')) {
                if (!empty($lesson->host_path) && File::exists(public_path($lesson->host_path))) {
                    File::delete(public_path($lesson->host_path));
                }

                $file = $request->file('host_path');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('session_lesson/'), $fileName);
                $filePath = 'session_lesson/' . $fileName;
            }

            $updateData = array_filter([
                'name' => $validated['name'] ?? null,
                'duration' => $validated['duration'] ?? null,
                'privacy' => $validated['privacy'] ?? null,
                'host_type' => $validated['host_type'] ?? null,
                'host_path' => $filePath ?? null,
                'description' => $validated['description'] ?? null,
            ], fn($value) => !is_null($value));

            $lesson->update($updateData);

            Toastr::success('Updated successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            dd($e->getMessage());
            return redirect()->back();
        }
    }




    public function destroy($id)
    {
        try {
            $lesson = SessionLesson::findOrFail($id);

            if (!empty($lesson->host_path) && File::exists(public_path($lesson->host_path))) {
                File::delete(public_path($lesson->host_path));
            }

            $lesson->delete();

            Toastr::success('Deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
