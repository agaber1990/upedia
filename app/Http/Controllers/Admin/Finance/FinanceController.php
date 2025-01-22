<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanaceStudentInvoice;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['invoices'] = FinanaceStudentInvoice::with('student', 'levels', 'staff_scheduled')->get();

        return view('backEnd.finance.index', $data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function invoice($id)
    {
        $finance_invoice = FinanaceStudentInvoice::with('student', 'levels', 'staff_scheduled.track', 'staff_scheduled.trackType.track_pricing_plans')->findOrFail($id);
        return view('backEnd.finance.invoice', compact('finance_invoice'));
    }
    public function show(Finance $finance)
    {
        //
    }
 
   /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
