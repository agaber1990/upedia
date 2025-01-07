<?php

namespace App\Http\Controllers\Admin\Academics;
use App\Http\Controllers\Controller;

use App\Models\PricingPlanType;
use Illuminate\Http\Request;
use App\ApiBaseMethod;
use App\Http\Requests\PricingPlanTypeRequest;
use Brian2694\Toastr\Facades\Toastr;
class PricingPlanTypeController extends Controller
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
            $pricing_plan_types = PricingPlanType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($pricing_plan_types, null);
            }
            return view('backEnd.academics.pricing_plan_type.index', compact('pricing_plan_types'));
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
    public function store(PricingPlanTypeRequest $request)
    {

        try {
            $pricing_plan_type = new PricingPlanType();
            $pricing_plan_type->name = $request->name;
            $result = $pricing_plan_type->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'pricing_plan_type has been created successfully');
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
            $pricing_plan_type = PricingPlanType::find($id);
            $pricing_plan_types = PricingPlanType::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['pricing_plan_type'] = $pricing_plan_type->toArray();
                $data['pricing_plan_types'] = $pricing_plan_types->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.academics.pricing_plan_type.index', compact('pricing_plan_type', 'pricing_plan_types'));

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

    public function update(PricingPlanTypeRequest $request, $id)
    {
        try {
            $pricing_plan_type = PricingPlanType::find($request->id);
            $pricing_plan_type->name = $request->name;
            $result = $pricing_plan_type->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'pricing_plan_type has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('pricing_plan_types');
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
            $tables = \App\tableList::getTableList('pricing_plan_type_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $pricing_plan_type = PricingPlanType::destroy($id);
                    if ($pricing_plan_type) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($pricing_plan_type) {
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
