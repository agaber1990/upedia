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
        $slotId = $this->id; // Fetch the 'id' parameter from the route
    
        return [
            'slot_day' => [
                'required',
                Rule::unique('slot_emps', 'slot_day')->ignore($slotId),
            ],
            'slot_start' => [
                'required',
                Rule::unique('slot_emps', 'slot_start')->ignore($slotId),
            ],
            'slot_end' => [
                'required',
                Rule::unique('slot_emps', 'slot_end')->ignore($slotId),
            ],
        ];
    }

    /**
     * Custom messages for validation.
     */
    public function messages()
    {
        return [
            'slot_day.unique' => 'This slot day has already been taken.',
            'slot_start.unique' => 'This slot start time has already been taken.',
            'slot_end.unique' => 'This slot end time has already been taken.',
        ];
    }
}
