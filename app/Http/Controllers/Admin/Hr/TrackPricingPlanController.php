<?php

namespace App\Http\Controllers\Admin\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackPricingPlanRequest;
use App\Models\TrackPricingPlan;
use Illuminate\Http\Request;

class TrackPricingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(TrackPricingPlanRequest $request, $id)
    {
        foreach ($request->pricing as $plan_id => $tracks) {
            foreach ($tracks as $tracktype_id => $price) {
                TrackPricingPlan::updateOrCreate(
                    [
                        'track_id' => $id,
                        'track_type_id' => $tracktype_id,
                        'pricing_plan_type_id' => $plan_id,
                    ],
                    [
                        'price' => $price,
                    ]
                );
            }
        }
        return redirect()->back()->with('success', __('academics.track_added_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TrackPricingPlan $trackPricingPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrackPricingPlan $trackPricingPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrackPricingPlan $trackPricingPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrackPricingPlan $trackPricingPlan)
    {
        //
    }
}
