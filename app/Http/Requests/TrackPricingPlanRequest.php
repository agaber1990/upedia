<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackPricingPlanRequest extends FormRequest
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
            'track_id' => 'required|exists:tracks,id',
            'pricing' => 'required|array',
            'pricing.*' => 'required|array',
            'pricing.*.*' => 'required|numeric',
        ];
    }
}