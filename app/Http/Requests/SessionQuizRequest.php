<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionQuizRequest extends FormRequest
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
            'session_id' => 'required',
            'level_id' => 'required',
            'title' => 'required|string|max:255',
            'instruction' => 'required|string|max:255',
            'min_percentage' => 'required|integer',
            'privacy' => 'required|in:locked,unlocked',
        ];
    }

    public function messages(): array
    {
        return [
            'session_id.required' => 'The session ID is required.',
            'level_id.required' => 'The level ID is required.',
            'title.required' => 'The title field is required.',
            'instruction.required' => 'The instruction field is required.',
            'min_percentage.required' => 'The min percentage field is required.',
            'privacy.required' => 'Privacy must be either locked or unlocked.',
        ];
    }
}
