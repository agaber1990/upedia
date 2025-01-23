<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\ApiBaseMethod;
use App\Models\Category;
use App\Models\CourseStudent;
use App\Models\FinanaceStudentInvoice;
use App\Models\Level;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SlotEmp;
use App\Models\StaffScheduled;
use App\Models\StaffSlot;
use App\Models\Track;
use App\Models\TrackAssignedStaff;
use App\SmStaff;
use App\SmStudent;
use App\SmSchool;
use App\SmAcademicYear;
use App\Models\StudentRecord;
use App\SmClass;
use Exception;

class SmCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('PM');
    }
    public function index(Request $request)
    {
        $slots = StaffSlot::with('slotEmp')->get();
        $staff = SmStaff::get();
        $trackAssignedStaff = TrackAssignedStaff::get();
        $tracks = Track::get();
        $categories = Category::get();
        $slotTime = SlotEmp::get();
        $staffScheduleds = StaffScheduled::all();
        $students = SmStudent::where('active_status', 1)->get();

        return view('backEnd.academics.sm_courses.index', compact('students', 'staff', 'slots', 'trackAssignedStaff', 'tracks', 'staffScheduleds', 'categories', 'slotTime'));
    }



    public function assignStudent($scheduledId, $id)
    {
        $data['staff_scheduleds'] = StaffScheduled::with('trackType', 'track.levels', 'category', 'staff')
            ->find($scheduledId); // Simplified query using find()

        // dd($data['staff_scheduleds']->slots());

        $data['slots'] = $data['staff_scheduleds']->slots();

        $data['levels'] = Level::where('id', '<=', $data['staff_scheduleds']->track->level_number)->get();
        $data['student_detail'] = SmStudent::where('id', $id)->first();
        $data['student_invoices'] = FinanaceStudentInvoice::where('student_id', $data['student_detail']->id)->get();
        return view('backEnd.academics.sm_courses.assign_student', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {


        $invoiceData = [
            'staff_scheduleds_id' => $request['staff_scheduleds_id'],
            'student_id' => $request['student_id'],
            'levels_id' => $request['levels_id'],
            'invoice_number' => "NO" . time(),
        ];
        FinanaceStudentInvoice::create($invoiceData);
        Toastr::success('Created successfully', 'Success');
        return redirect()->back();
    }

    public function show($id)
    {
        $course = StaffScheduled::findOrFail($id);
        $course_students = CourseStudent::where('course_id', $id)
        ->with('student')
        ->with('course')
        ->get();
        $categories = Category::get();
        $students = SmStudent::get();

        return view('backEnd.academics.sm_courses.show', compact('categories','course','course_students', 'students'));
    }

    public function storeCourseToStudent(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:staff_scheduleds,id',
                'student_id' => [
                    'required',
                    'exists:sm_students,id',
                    function ($attribute, $value, $fail) use ($request) {
                        $exists = CourseStudent::where('course_id', $request->course_id)
                            ->where('student_id', $value)
                            ->exists();

                        if ($exists) {
                            $fail('The student is already enrolled in this course.');
                        }
                    },
                ],

            ]);
            $validated = [
                'course_id' => $request->course_id,
                'student_id' => $request->student_id,
            ];
            CourseStudent::create($validated);
            Toastr::success('Created successfully', 'Success');
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error('The student is already enrolled in this course.', 'Error');
            return redirect()->back();
        }
    }


    public function course_students_delete(Request $request, $id)
    {
        CourseStudent::destroy($request->id);
        Toastr::success('Operation successful', 'Success');
        return back();
    }
}
