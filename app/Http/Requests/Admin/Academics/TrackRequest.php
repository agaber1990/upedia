<?php
namespace App\Http\Requests\Admin\Academics;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrackRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as necessary
    }

    public function rules()
    {
        return [
            'track_name_en' => 'required|string|max:255',
            'track_name_ar' => 'required|string|max:255',
            'level_number' => 'required|exists:levels,id',
            'cat_id' => 'required|exists:categories,id',
            'session' => 'required|integer|min:1|max:20',
            'schedule' => 'required|in:once,weekly,twice',
            'valid_for' => 'required|array',
            'valid_for.*' => 'exists:track_types,id', // Assuming there is a table for valid_for
        ];
    }

    public function messages()
    {
        return [
            'track_name_en.required' => __('academics.track_name_en_required'),
            'track_name_ar.required' => __('academics.track_name_ar_required'),
            'level_number.required' => __('academics.level_number_required'),
            'schedule.required' => __('academics.schedule_required'),
            'cat_id.required' => __('academics.categories_required'),
            'valid_for.required' => __('academics.valid_for_required'),
        ];
    }
}
