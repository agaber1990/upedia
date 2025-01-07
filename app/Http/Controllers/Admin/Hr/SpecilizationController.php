<?php

namespace App\Http\Controllers\Admin\Hr;
use App\Http\Controllers\Controller;

use App\ApiBaseMethod;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Models\Specilization;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Hr\SpecilizationRequest;

class SpecilizationController extends Controller
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
            $specilizations = Specilization::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($specilizations, null);
            }

            return view('backEnd.humanResource.specilization.specilization', compact('specilizations'));
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
    public function store(SpecilizationRequest $request)
    {

        try {
            $specilization = new Specilization();
            $specilization->title = $request->title;
            $specilization->school_id = Auth::user()->school_id;
            $result = $specilization->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'specilization has been created successfully');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        try {
            // $specilization = Specilization::find($id);
            $specilization = Specilization::find($id);
            $specilizations = Specilization::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['specilization'] = $specilization->toArray();
                $data['specilizations'] = $specilizations->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.humanResource.specilization.specilization', compact('specilization', 'specilizations'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(SpecilizationRequest $request, $id)
    {


        // if ($validator->fails()) {
        //     if (ApiBaseMethod::checkUrl($request->fullUrl())) {
        //         return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
        //     }

        // }
        // school wise uquine validation

        try {
            // $specilization = Specilization::find($request->id);
            $specilization = Specilization::find($request->id);
            $specilization->title = $request->title;
            $result = $specilization->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'specilization has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('specilization');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function destroy(Request $request, $id)
    {

        try {
            $tables = \App\tableList::getTableList('specilization_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $specilization = Specilization::destroy($id);
                    if ($specilization) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($specilization) {
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
}
