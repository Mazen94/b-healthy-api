<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;
class RegisterNutritionist extends FormRequest
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
            'email' => 'required|string|email',
            'firstName' => 'required',
            'password' => 'required|min:'.Config::get('constants.MIN_PASSWORD_LENGTH').'|max:'.Config::get('constants.MAX_PASSWORD_LENGTH'),
            'lastName' => 'required',
        ];
    }
}
