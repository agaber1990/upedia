<?php

namespace App\Http\Controllers\Admin\Academics;
use App\Http\Controllers\Controller;
use App\ApiBaseMethod;
use App\Http\Requests\DiscountPlanRequest;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\DiscountPlan;
use App\Models\SlotEmp;
use App\Models\StaffSlot;
use App\Models\Track;
use App\Models\TrackAssignedStaff;
use App\SmStaff;

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
            $slotTime = SlotEmp::get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($staff, null);
            }
            return view('backEnd.academics.sales_management.index', compact('staff','slots','trackAssignedStaff','tracks'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
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
