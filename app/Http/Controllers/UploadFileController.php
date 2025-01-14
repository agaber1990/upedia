<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadFileController extends Controller {

    public function upload_image(Request $request) {

        $request->validate([
            'files.*' => [
                'required',
                'image',
                'mimes:jpeg,jpg,bmp,png,svg,gif'
            ],
        ], [], [
            'files.*' => 'File'
        ]);
        if (!file_exists('/uploads/editor-image')) {
            mkdir('/uploads/editor-image', 0777, true);
        }
        $files = $request->files;
        $image_url = [];
        foreach ($files as $file) {
            foreach($file as $k => $f){
                $fileName = $f->getClientOriginalName() . time() . "." . $f->getClientOriginalExtension();
                $f->move('/uploads/editor-image/', $fileName);
                $image_url[$k] = asset('/uploads/editor-image/' . $fileName);

            }
        }

        return response()->json($image_url);
    }
}