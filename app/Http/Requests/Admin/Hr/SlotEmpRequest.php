<?php

namespace App\Http\Requests\Admin\Hr;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SlotEmpRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $school_id = auth()->user()->school_id;

        return [
            'slot_day' => [
                'required', // slot name is required
            ],
            'slot_start' => [
                'required',
            ],
            'slot_end' => [
                'required',
                ]
        ];
    }
}
