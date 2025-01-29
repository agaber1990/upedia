<?php

namespace App\Http\Controllers\Admin\Academics;
use App\Http\Controllers\Controller;

use App\ApiBaseMethod;
use App\Http\Requests\Admin\Academics\TrackTypeRequest;
use App\Models\TrackType;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class TrackTypeController extends Controller
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
            $track_types = TrackType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($track_types, null);
            }
            return view('backEnd.academics.track_types.index', compact('track_types'));
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
    public function store(TrackTypeRequest $request)
    {

        try {
            $track_types = new TrackType();
            $track_types->name = $request->name;
            $track_types->count_of_students = $request->count_of_students;
            $result = $track_types->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'track_types has been created successfully');
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
            $track_type = TrackType::find($id);
            $track_types = TrackType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['track_type'] = $track_type->toArray();
                $data['track_types'] = $track_types->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.academics.track_types.index', compact('track_type', 'track_types'));

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

    public function update(TrackTypeRequest $request, $id)
    {
        try {
            $track_types = TrackType::find($request->id);
            $track_types->name = $request->name;
            $track_types->count_of_students = $request->count_of_students;
            $result = $track_types->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'track_types has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('track_types');
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
            $tables = \App\tableList::getTableList('track_types_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $track_types = TrackType::destroy($id);
                    if ($track_types) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($track_types) {
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
