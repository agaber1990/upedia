<?php

namespace App\Http\Requests\Admin\Academics;

use Illuminate\Foundation\Http\FormRequest;


class TrackSessionRequest extends FormRequest
{
 
 /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'track_id' => 'required|exists:tracks,id',
            'session_name_en' => 'reqired|string',
            'session_name_ar' => 'reqired|string',

        ];
    }
}
