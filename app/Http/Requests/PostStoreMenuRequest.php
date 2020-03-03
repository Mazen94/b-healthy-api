<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;

class PostStoreMenuRequest extends FormRequest
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
            'type_menu' => 'required|string',
            'nom' => 'required|string',
            'max_age' => 'required|integer|between:' . Config::get('constants.MIN_AGE_LENGTH') . ',' . Config::get(
                    'constants.MAX_AGE_LENGTH'
                ),

            'min_age' => 'required|integer|between:' . Config::get('constants.MIN_AGE_LENGTH') . ',' . Config::get(
                    'constants.MAX_AGE_LENGTH'
                ),
            'calorie' => 'integer|between:' . Config::get('constants.MIN_AGE_LENGTH') . ',' . Config::get(
                    'constants.MAX_AGE_LENGTH'
                ),
        ];
    }
}
