<?php

namespace App\Http\Requests\Admin\Academics;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrackTypeRequest extends FormRequest
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
        $trackTypeId = $this->route('track_type'); // Ensure this matches the route model binding

        return [
            'name' => [
                'required',
                'max:200',
                Rule::unique('track_types')->ignore($this->id), // Ensure this matches hidden input field
            ],
            'count_of_students' => [
                'nullable', // Allow null if the same value is submitted
                'integer'
            ],
        ];
    }
}
