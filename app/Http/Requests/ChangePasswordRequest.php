<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|string',
            'newPassword' => 'required|min:' . Config::get('constants.MIN_PASSWORD_LENGTH') . '|max:' . Config::get(
                    'constants.MAX_PASSWORD_LENGTH'
                ),
        ];
    }
}
