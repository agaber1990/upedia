<?php

namespace App\Http\Controllers\Admin\Academics;
use App\Http\Controllers\Controller;

use App\ApiBaseMethod;
use App\Http\Requests\EmAcademyTypeRequest;
use App\Models\EmAcademyType;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class EmAcademyTypeController extends Controller
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
            $employee_academy_types = EmAcademyType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($employee_academy_types, null);
            }
            return view('backEnd.academics.employee_academy_type.employee_academy_type', compact('employee_academy_types'));
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
    public function store(EmAcademyTypeRequest $request)
    {

        try {
            $employee_academy_type = new EmAcademyType();
            $employee_academy_type->name = $request->name;
            $result = $employee_academy_type->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'employee_academy_type has been created successfully');
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
            $employee_academy_type = EmAcademyType::find($id);
            $employee_academy_types = EmAcademyType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['employee_academy_type'] = $employee_academy_type->toArray();
                $data['employee_academy_types'] = $employee_academy_types->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.academics.employee_academy_type.employee_academy_type', compact('employee_academy_type', 'employee_academy_types'));

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(EmAcademyTypeRequest $request, $id)
    {
        try {
            $employee_academy_type = EmAcademyType::find($request->id);
            $employee_academy_type->name = $request->name;
            $result = $employee_academy_type->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'employee_academy_type has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('employee_academy_type');
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
            $tables = \App\tableList::getTableList('employee_academy_type_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $employee_academy_type = EmAcademyType::destroy($id);
                    if ($employee_academy_type) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($employee_academy_type) {
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
