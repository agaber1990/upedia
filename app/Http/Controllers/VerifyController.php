<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SmGeneralSettings;
use Brian2694\Toastr\Facades\Toastr;

class VerifyController extends Controller
{

    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return redirect('/');

		}catch (\Exception $e) {
		      Toastr::error('Operation Failed', 'Failed');
		       return redirect()->back();
		}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePurchasecode(Request $request, $id)
    {
        return redirect('/dashboard')->with('success', 'Purchase Code Verified');

    }

}
