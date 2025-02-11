<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\SessionQuizRequest;
use App\Models\SessionQuiz;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SessionQuizController extends Controller
{


    public function store(SessionQuizRequest $request)
    {
        try {
            $validated = $request->validated();
            SessionQuiz::create($validated);
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
                'instruction' => 'nullable|string|max:255',
                'min_percentage' => 'nullable|integer',
                'privacy' => 'nullable|in:locked,unlocked',
            ]);

            $quiz = SessionQuiz::findOrFail($id);

            $updateData = array_filter([
                'title' => $validated['title'] ?? null,
                'instruction' => $validated['instruction'] ?? null,
                'min_percentage' => $validated['min_percentage'] ?? null,
                'privacy' => $validated['privacy'] ?? null,
            ], fn($value) => !is_null($value));


            $quiz->update($updateData);

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
            $quiz = SessionQuiz::findOrFail($id);
            $quiz->delete();
            Toastr::success('Deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
