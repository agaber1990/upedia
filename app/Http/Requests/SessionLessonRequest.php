<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionLessonRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'duration' => 'required|integer',
            'privacy' => 'required|in:locked,unlocked',
            'host_type' => 'required|in:image,youtube,video,pdf,word,excel',
            'host_path' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('host_type') === 'youtube' && !is_string($value)) {
                        $fail('The host_path must be a valid YouTube URL.');
                    } elseif ($this->input('host_type') !== 'youtube' && !$this->hasFile('host_path')) {
                        $fail('The host_path must be a valid file.');
                    }
                },
            ],
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'session_id.required' => 'The session ID is required.',
            'level_id.required' => 'The level ID is required.',
            'name.required' => 'The name field is required.',
            'duration.required' => 'The duration field is required.',
            'privacy.required' => 'Privacy must be either locked or unlocked.',
            'host_type.required' => 'The host type is required.',
            'host_path.required' => 'The host path must be provided.',
            'description.required' => 'The description is required.',
        ];
    }
}
