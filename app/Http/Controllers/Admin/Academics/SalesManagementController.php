<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Http\Controllers\Controller;
use App\ApiBaseMethod;
use App\Models\Category;
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
        $slots = StaffSlot::with('slotEmp')->get();
        $staff = SmStaff::get();
        $trackAssignedStaff = TrackAssignedStaff::get();
        $tracks = Track::get();
        $categories = Category::get();
        $slotTime = SlotEmp::get();
        $staffScheduleds = StaffScheduled::all();
        $students = SmStudent::where('active_status', 1)->get();

        return view('backEnd.academics.sales_management.index', compact('students', 'staff', 'slots', 'trackAssignedStaff', 'tracks', 'staffScheduleds', 'categories', 'slotTime'));
    }



    public function assignStudent($scheduledId, $id)
    {
        $data['staff_scheduleds'] = StaffScheduled::with('trackType', 'track.levels', 'category', 'staff')
            ->find($scheduledId); // Simplified query using find()

        // dd($data['staff_scheduleds']);
        // dd($data['staff_scheduleds']->slots());

        $data['slots'] = $data['staff_scheduleds']->slots();

        $data['levels'] = Level::where('id', '<=', $data['staff_scheduleds']->track->level_number)->get();
        $data['student_detail'] = SmStudent::where('id', $id)->first();
        return view('backEnd.academics.sales_management.assign_student', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'staff_scheduleds_id' => 'required|exists:staff_scheduleds,id',
            'student_id' => 'required|exists:sm_students,id',
            'levels_ids' => 'required|exists:levels,id',
            'invoice_number' => 'required|string',
        ]);


        $invoiceData = [
            'staff_scheduleds_id' => $request['staff_scheduleds_id'],
            'student_id' => $request['student_id'],
            'levels_ids' => $request['levels_ids'],
            'invoice_number' => "NO" . time(),
        ];
        FinanaceStudentInvoice::create($invoiceData);
    }

    /**
     * Store a newly created resource in storage.
     */
}
