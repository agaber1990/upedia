<?php

namespace App\Http\Controllers\Admin\Hr;

use App\Http\Controllers\Controller;
use App\ApiBaseMethod;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\SlotEmp;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Hr\SlotEmpRequest;

class SlotEmpController extends Controller
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
            $slotemployees = SlotEmp::get(); // Get all slot records
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($slotemployees, null);
            }

            return view('backEnd.humanResource.slotemployees.index', compact('slotemployees'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlotEmpRequest $request)
    {
        try {
            $slotemployee = new SlotEmp();
            $slotemployee->slot_day = implode(',', $request->slot_day);
            $slotemployee->slot_start = $request->slot_start;
            $slotemployee->slot_end = $request->slot_end;
            $slotemployee->school_id = Auth::user()->school_id;

            $result = $slotemployee->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Slot has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {

        try {
            // $emtype = EmType::find($id);
            $slotemployee = SlotEmp::find($id);
            $slotemployees = SlotEmp::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['slotemployee'] = $slotemployee->toArray();
                $data['slotemployees'] = $slotemployees->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.humanResource.slotemployees.index', compact('slotemployee', 'slotemployees'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(SlotEmpRequest $request, $id)
    {
        try {
            $slotemployee = SlotEmp::find($id);
            if (!$slotemployee) {
                Toastr::error('Slot not found', 'Failed');
                return redirect()->route('slotemployee.index');
            }

            $slotemployee->slot_day = implode(',', $request->slot_day);
            $slotemployee->slot_start = $request->slot_start;
            $slotemployee->slot_end = $request->slot_end;

            $result = $slotemployee->save();
            Toastr::success('Operation successful', 'Success');
            return redirect('slotemployee.index');

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }




    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request, $id)
    {

        try {
            $tables = \App\tableList::getTableList('slotemployee_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $slotemployee = SlotEmp::destroy($id);
                    if ($slotemployee) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($slotemployee) {
                                return ApiBaseMethod::sendResponse(null, 'Deleted successfully');
                            } else {
                                return ApiBaseMethod::sendError('Something went wrong, please try again');
                            }
                        }
                        Toastr::success('Operation successful', 'Success');
                        return redirect()->back();
                    } else {
                        Toastr::error('Operation Failed', 'Failed');
                        return redirect()->back();
                    }
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {

                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    /**
     * Handle API response for CRUD operations.
     */

}
