<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanaceStudentInvoice;
use App\Models\Finance;
use App\Models\Track;
use App\SmStudent;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['invoices'] = FinanaceStudentInvoice::with('student', 'levels', 'staff_scheduled')->get();
        $data['students'] = SmStudent::get();
        $data['tracks'] = Track::with('staff_scheduled')->get();


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
        $validated =  $request->validate([
            'staff_scheduleds_id' => 'required',
            'student_id' => 'required',
            'levels_id' => 'required',
        ]);

        $invoiceData = [
            'staff_scheduleds_id' => $validated['staff_scheduleds_id'],
            'student_id' => $validated['student_id'],
            'levels_id' => $validated['levels_id'],
            'invoice_number' => "NO" . time(),
        ];
        FinanaceStudentInvoice::create($invoiceData);
        return response()->json("Success", 200);
    }
    /**
     * Display the specified resource.
     */
    public function invoice($id)
    {
        $finance_invoice = FinanaceStudentInvoice::with('student', 'levels', 'staff_scheduled.track', 'staff_scheduled.trackType.track_pricing_plans')->findOrFail($id);
        return view('backEnd.finance.invoice', compact('finance_invoice', 'id'));
    }
    public function download_pdf($id)
    {
        set_time_limit(300);
        // Retrieve the finance invoice with related data or throw a 404 error if not found
        $finance_invoice = FinanaceStudentInvoice::with([
            'student',
            'levels',
            'staff_scheduled.track',
            'staff_scheduled.trackType.track_pricing_plans'
        ])->findOrFail($id);

        // Generate the PDF with the specified view and data
        $pdf = Pdf::loadView(
            'backEnd.finance.invoice_pdf',
            [
                'finance_invoice' => $finance_invoice,
            ]
        )->setPaper('A4', 'landscape');

        // Stream the PDF in the browser
        return $pdf->stream('invoice.pdf');

        // Alternatively, to download the PDF, uncomment the line below:
        // return $pdf->download('invoice.pdf');


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
