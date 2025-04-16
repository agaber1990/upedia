<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\Models\SessionAssignment;
use App\Models\SessionLesson;
use App\Models\SessionQuiz;
use App\Models\Track;
use App\Models\TrackLevel;
use App\Models\TrackLevelSession;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class TrackLevelSessionController extends Controller
{
    public function index(Request $request, $track_id, $level_id)
    {
        $level = TrackLevel::where('id', $level_id)->first();
        $track = Track::where('id', $track_id)->first();
        $menus = TrackLevelSession::where('track_id', $track_id)->where('level_id', $level_id)->with('track', 'level')->get();
        $lessons = SessionLesson::where('level_id', $level_id)->get();
        $assignments = SessionAssignment::where('level_id', $level_id)->get();
        $quiz = SessionQuiz::where('level_id', $level_id)->get();

        $sessionQuiz = TrackLevelSession::where('level_id',$level_id)->with('SessionQuizzes')->get();

        // dd($sessionQuiz);
        return view('backEnd.academics.sessions.index', compact('track', 'menus', 'level', 'lessons', 'assignments', 'quiz', 'sessionQuiz'));
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'track_id' => 'required|exists:tracks,id',
                'level_id' => 'required|exists:levels,id',
                'name_en' => 'required|string',
                'name_ar' => 'required|string',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'file' => 'required|array',
                'file.*' => 'file|mimes:pdf,doc,docx',
            ]);

            $fileData = [];

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('courses_student_sessions/'), $fileName);

                    $fileData[] = 'courses_student_sessions/' . $fileName;
                }
            }

            TrackLevelSession::create([
                'track_id' => $validated['track_id'],
                'level_id' => $validated['level_id'],
                'name_en' => $validated['name_en'],
                'name_ar' => $validated['name_ar'],
                'description_en' => $validated['description_en'],
                'description_ar' => $validated['description_ar'],
                'file' => $fileData,
            ]);


            Toastr::success('Created successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:track_levle_sessions,id',
            'track_id' => 'required|exists:tracks,id',
            'level_id' => 'required|exists:levels,id',
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'file' => 'nullable|array',
            'file.*' => 'file|mimes:pdf,doc,docx',
        ]);

        $session = TrackLevelSession::findOrFail($validated['id']);

        if ($request->hasFile('file')) {
            if ($session->file) {
                foreach ($session->file as $file) {
                    $filePath = public_path($file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
            $fileData = [];
            foreach ($request->file('file') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('courses_student_sessions/'), $fileName);
                $fileData[] = 'courses_student_sessions/' . $fileName;
            }
            $session->update(['file' => $fileData]);
        } else {
            if (empty($session->file)) {
                $session->update(['file' => ['default_placeholder.pdf']]);
            }
        }
        $session->update([
            'name_en' => $validated['name_en'],
            'name_ar' => $validated['name_ar'],
            'description_en' => $validated['description_en'],
            'description_ar' => $validated['description_ar'],
        ]);

        Toastr::success('Updated successfully', 'Success');
        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $session = TrackLevelSession::findOrFail($id);
        $session->delete();
    }
}
