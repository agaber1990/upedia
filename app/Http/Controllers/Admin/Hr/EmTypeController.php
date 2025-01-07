<?php

namespace App\Http\Controllers\Admin\Hr;
use App\Http\Controllers\Controller;

use App\ApiBaseMethod;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Models\EmType;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Hr\EmTypeRequest;

class EmTypeController extends Controller
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
            $emtypes = EmType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($emtypes, null);
            }

            return view('backEnd.humanResource.emtypes.index', compact('emtypes'));
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
    public function store(EmTypeRequest $request)
    {

        try {
            $emtype = new EmType();
            $emtype->title = $request->title;
            $emtype->school_id = Auth::user()->school_id;
            $result = $emtype->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'emtype has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }    }

       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        try {
            // $emtype = EmType::find($id);
            $emtype = EmType::find($id);
            $emtypes = EmType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['emtype'] = $emtype->toArray();
                $data['emtypes'] = $emtypes->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.humanResource.emtypes.index', compact('emtype', 'emtypes'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(EmTypeRequest $request, $id)
    {


        // if ($validator->fails()) {
        //     if (ApiBaseMethod::checkUrl($request->fullUrl())) {
        //         return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
        //     }

        // }
        // school wise uquine validation

        try {
            // $emtype = EmType::find($request->id);
            $emtype = EmType::find($request->id);
            $emtype->title = $request->title;
            $result = $emtype->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'emtype has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('emtype');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function destroy(Request $request, $id)
    {

        try {
            $tables = \App\tableList::getTableList('emtype_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $emtype = EmType::destroy($id);
                    if ($emtype) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($emtype) {
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
