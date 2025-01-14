<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => 'string|max:255', 
            'name_ar' => 'string|max:255', 
            'level_id' => 'array',        
            'level_id.*' => 'integer|exists:levels,id', 
            'price' => 'array',          
            'price.*' => 'numeric|min:0', 
        ];
    }
}
