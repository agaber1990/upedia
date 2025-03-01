<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmExamSignature;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class ExamSignatureSettingsController extends Controller
{

    public function index()
    {
        $allSignature = SmExamSignature::get();
        return view('backEnd.examination.examSignatureSettings', compact('allSignature'));
    }

    public function store(Request $request)
    {
        foreach(gv($request, 'exam_signature') as $signature){
            $validator = Validator::make($signature, [
                'title' => "required",
            ]);
            if ($validator->fails()) {
                Toastr::error('Empty Submission', 'Failed');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        try{
            foreach(gv($request, 'exam_signature') as $signature){
                $this->formatData($signature);
            }
            Toastr::success('Operation Successfully', 'Success');
            return redirect()->route('exam-signature-settings');
        }catch(\Exception $e){
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try{
            $allDataDeletes = SmExamSignature::get();
            foreach($allDataDeletes as $allDataDelete){
                $allDataDelete->delete();
            }

            foreach(gv($request, 'exam_signature') as $signature){
                $this->formatData($signature);
            }
            Toastr::success('Update Successfully', 'Success');
            return redirect()->route('exam-signature-settings');
        }catch(\Exception $e){
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    private function formatData($request){
        $destination='/uploads/upload_contents/';
        $storeData = new SmExamSignature();
        $storeData->title = gv($request, 'title');
        if(gv($request, 'image_path')){
            if(gv($request, 'signature')){
                if (file_exists(gv($request, 'image_path'))) {
                    unlink(gv($request, 'image_path'));
                }
                $storeData->signature = fileUpload(gv($request, 'signature'), $destination);
            }else{
                $storeData->signature = gv($request, 'image_path');
            }
        }else{
            $storeData->signature = fileUpload(gv($request, 'signature'), $destination);
        }
        $storeData->active_status = (gv($request, 'active_status') ? 1 : 0);
        $storeData->school_id = auth()->user()->school_id;
        $storeData->academic_id = getAcademicId();
        $storeData->save();
    }
}
