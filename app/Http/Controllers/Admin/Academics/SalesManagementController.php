<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\ApiBaseMethod;
use App\Models\Category;
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

class SalesManagementController extends Controller
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
        try {
            $slots = StaffSlot::with('slotEmp')->get();
            $staff = SmStaff::get();
            $trackAssignedStaff = TrackAssignedStaff::get();
            $tracks = Track::get();
            $categories = Category::get();
            $slotTime = SlotEmp::get();
            $staffScheduleds = StaffScheduled::all();
            $students = SmStudent::where('active_status', 1)->get();
            // dd($students);

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($staff, null);
            }
            return view('backEnd.academics.sales_management.index', compact('students', 'staff', 'slots', 'trackAssignedStaff', 'tracks', 'staffScheduleds', 'categories', 'slotTime'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function assignStudent($id)
    {
        $data['schools'] = SmSchool::get();
        $data['sessions'] = SmAcademicYear::get(['id', 'year', 'title']);
        $data['student_records'] = StudentRecord::where('student_id', $id)->where('active_status', 1)
            ->when(moduleStatusCheck('University'), function ($query) {
                $query->whereNull('class_id');
            })->get();
        $data['student_detail'] = SmStudent::where('id', $id)->first();
        $data['classes'] = SmClass::get(['id', 'class_name']);
        $data['siblings'] = SmStudent::where('parent_id', $data['student_detail']->parent_id)->whereNotNull('parent_id')->where('id', '!=', $id)->status()->withoutGlobalScope(StatusAcademicSchoolScope::class)->get();
        return view('backEnd.academics.sales_management.assign_student', $data);
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
}
