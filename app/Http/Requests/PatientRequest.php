<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class PatientRequest extends FormRequest
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
        if ($this->route()->getName() == Config::get('constants.ROUTE_NAME_REGISTER_PATIENT')) {
            return [
                'email' => 'required|string|email|unique:patients',
                'firstName' => 'required',
                'lastName' => 'required',
                'password' => 'required|min:' . Config::get('constants.MIN_PASSWORD_LENGTH') . '|max:' . Config::get(
                        'constants.MAX_PASSWORD_LENGTH'
                    ),
                'numberPhone' => 'required|string',
                'profession' => 'required|string',
                'gender' => 'required|integer',
            ];
        }
        else {
            $user = auth()->user();
            return [
                'email' => [
                    'required',
                    Rule::unique('patients', 'email')->ignore($user->id)
                ],
                'firstName' => 'required',
                'lastName' => 'required',
                'password' => 'min:' . Config::get('constants.MIN_PASSWORD_LENGTH') . '|max:' . Config::get(
                        'constants.MAX_PASSWORD_LENGTH'
                    ),
                'numberPhone' => 'required|string',
                'profession' => 'required|string',
                'gender' => 'required|string',
            ];
        }
    }
}
