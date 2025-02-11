<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionAssignmentRequest extends FormRequest
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
            'marks' => 'required|integer',
            'min_percentage' => 'required|integer',
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
            'submit_date' => 'required',
            'description' => 'required|string',
            'privacy' => 'required|in:locked,unlocked',
        ];
    }


    public function messages(): array
    {
        return [
            'session_id.required' => 'The session ID is required.',
            'level_id.required' => 'The level ID is required.',
            'title.required' => 'The title field is required.',
            'marks.required' => 'The marks field is required.',
            'min_percentage.required' => 'The min percentage field is required.',
            'attachment.required' => 'attachment must be either locked or unlocked.',
            'submit_date.required' => 'submit_date must be either locked or unlocked.',
            'description.required' => 'The description is required.',
            'privacy.required' => 'Privacy must be either locked or unlocked.',
        ];
    }
}
