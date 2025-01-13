<?php

namespace App\Http\Controllers\Admin\Academics;
use App\Http\Controllers\Controller;
use App\ApiBaseMethod;
use App\Http\Requests\DiscountPlanRequest;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\DiscountPlan;
use App\Models\Level;

class DiscountPlanController extends Controller
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
            $discountPlans = DiscountPlan::get();
            $levels = Level::get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($discountPlans, null);
            }
            return view('backEnd.academics.discount_plan.discount_plan', compact('discountPlans','levels'));
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
    public function store(DiscountPlanRequest $request)
    {

        try {
            $discountPlan = new DiscountPlan();
            $discountPlan->percentage = $request->percentage;
            $discountPlan->level_id = $request->level_id;

            $result = $discountPlan->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'discountPlan has been created successfully');
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
            $discountPlan = DiscountPlan::find($id);
            $discountPlans = DiscountPlan::get();
            $levels = Level::get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['discountPlans'] = $discountPlan->toArray();
                $data['discountPlans'] = $discountPlans->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('backEnd.academics.discount_plan.discount_plan', compact('discountPlan','levels', 'discountPlans'));

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

    public function update(DiscountPlanRequest $request, $id)
    {
        try {
            $discountPlan = DiscountPlan::find($request->id);
            $discountPlan->percentage = $request->percentage;
            $discountPlan->level_id = $request->level_id;

            $result = $discountPlan->save();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'discountPlan has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            }
            Toastr::success('Operation successful', 'Success');
            return redirect('discount_plans');
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
            $tables = \App\tableList::getTableList('discountPlan_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $discountPlan = DiscountPlan::destroy($id);
                    if ($discountPlan) {
                        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                            if ($discountPlan) {
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
