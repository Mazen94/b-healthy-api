<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;

class VisitRequest extends FormRequest
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
        return [
            'weight' => 'required|integer|min:' . Config::get('constants.MIN_WEIGHT_LENGTH') . '|max:' . Config::get(
                    'constants.MAX_WEIGHT_LENGTH'
                ),
            'belly' => 'nullable|integer',
            'chest' => 'nullable|integer',
            'legs' => 'nullable|integer',
            'neck' => 'nullable|integer',
            'tall' => 'nullable|integer',
            'scheduled_at' => 'date',
            'done_at' => 'nullable|date',
            'note' => 'nullable|string'
        ];
    }
}
