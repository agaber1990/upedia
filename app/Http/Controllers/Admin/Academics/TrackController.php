<?php

namespace App\Http\Controllers\Admin\Academics;

use App\Models\{DiscountPlan, Track, Level, TrackPricingPlan, TrackType};
use App\Models\Category;
use App\Models\PricingPlanType;
use App\tableList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Admin\Academics\TrackRequest;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $tracks = Track::get();
            $levels = Level::all();
            $valid_for = TrackType::all();
            $categories = Category::all();

            return view('backEnd.academics.tracks', compact('tracks', 'levels', 'valid_for', 'categories'));
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


    public function store(TrackRequest $request)
    {
        try {
            $track = new Track();
            $track->cat_id = $request->cat_id;
            $track->track_name_en = $request->track_name_en;
            $track->track_name_ar = $request->track_name_ar;
            $track->level_number = $request->level_number;
            $track->session = $request->session;
            $track->schedule = $request->schedule;
            $track->valid_for = json_encode($request->valid_for);
            $track->save();

            Toastr::success('Created successfully', 'Success');
            return redirect()->route('tracks')->with('success', __('academics.track_added_success'));
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

        $tracks = Track::get();
        $track = Track::find($id);
        $levels = Level::all();
        $valid_for = TrackType::all();
        $categories = Category::all();

        return view('backEnd.academics.tracks', compact('tracks', 'levels', 'valid_for', 'track', 'categories'));
    }
    public function tracksPricingPlan(Request $request, $id)
    {

        $tracks = Track::get();
        $track = Track::find($id);
        $levels = Level::all();
        $pricing_plan_types = PricingPlanType::all();
        $tracktypes = TrackType::whereIn("id",  json_decode($track->valid_for))->get();
        $discount_plans = DiscountPlan::all();
        $track_pricing_plans = TrackPricingPlan::where('track_id', $track->id)->get();

        $pricing_data = [];
        foreach ($track_pricing_plans as $plan) {
            $pricing_data[$plan->pricing_plan_type_id][$plan->track_type_id] = $plan->price;
        }

        return view('backEnd.academics.trackspricingplan', compact('tracks', 'levels', 'pricing_plan_types', 'tracktypes', 'track', 'discount_plans', 'track_pricing_plans', 'pricing_data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Track $track)
    {
        //
    }

    /**
     * Update the specified track in the database.
     *
     * @param  TrackRequest  $request
     * @param  Track  $track
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TrackRequest $request,  $id)
    {
        // Update track details
        $track = Track::find($id);
        $track->cat_id = $request->cat_id;
        $track->track_name_en = $request->track_name_en;
        $track->track_name_ar = $request->track_name_ar;
        $track->level_number = $request->level_number;
        $track->session = $request->session;
        $track->schedule = $request->schedule;
        $track->valid_for = json_encode($request->valid_for); // Update valid_for as JSON
        $track->save();

        // Redirect back with success message
        return redirect()->route('tracks')->with('success', __('academics.track_updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request, $id)
    {

        try {
            $tables = \App\tableList::getTableList('track_id', $id);
            // return $tables;
            try {
                if ($tables == null) {

                    $track = Track::destroy($id);
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
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
