<?php


namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionAssignmentRequest;
use Illuminate\Http\Request;
use App\Models\SessionAssignment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;


class SessionAssignmentController extends Controller
{


    public function store(SessionAssignmentRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('session_assignment/'), $fileName);
                $filePath = 'session_assignment/' . $fileName;
            } else {
                $filePath = null;
            }

            SessionAssignment::create([
                'session_id' => $validated['session_id'],
                'level_id' => $validated['level_id'],
                'title' => $validated['title'],
                'marks' => $validated['marks'],
                'min_percentage' => $validated['min_percentage'],
                'attachment' => $filePath,
                'submit_date' => $validated['submit_date'],
                'description' => $validated['description'],
                'privacy' => $validated['privacy'],
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




    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'marks' => 'nullable|integer',
                'min_percentage' => 'nullable|integer',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
                'submit_date' => 'nullable',
                'description' => 'nullable|string',
                'privacy' => 'nullable|in:locked,unlocked',
            ]);

            $assignment = SessionAssignment::findOrFail($id);
            $filePath = $assignment->attachment;


            if ($request->hasFile('attachment')) {
                if ($assignment->attachment && File::exists(public_path($assignment->attachment))) {
                    File::delete(public_path($assignment->attachment));
                }
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('session_assignment/'), $fileName);
                $filePath = 'session_assignment/' . $fileName;
            }


            // Update only the fields that are not empty or null

            $updateData = array_filter([
                'title' => $validated['title'] ?? null,
                'marks' => $validated['marks'] ?? null,
                'min_percentage' => $validated['min_percentage'] ?? null,
                'attachment' => $filePath ?? null,
                'submit_date' => $validated['submit_date'] ?? null,
                'description' => $validated['description'] ?? null,
                'privacy' => $validated['privacy'] ?? null,
            ], fn($value) => !is_null($value));


            $assignment->update($updateData);

            Toastr::success('Updated successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $assignment = SessionAssignment::findOrFail($id);
            if ($assignment->attachment && File::exists(public_path($assignment->attachment))) {
                File::delete(public_path($assignment->attachment));
            }

            $assignment->delete();

            Toastr::success('Deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
