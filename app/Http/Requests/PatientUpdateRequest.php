<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class PatientUpdateRequest extends FormRequest
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
        $user = auth()->user();
        return [
            'email' => [
                'required',
                Rule::unique('patients', 'email')->ignore($user->id)
            ],
            'firstName' => 'required',
            'lastName' => 'required',
            'numberPhone' => 'required|string',
            'profession' => 'required|string',
            'password' => 'string',
            'gender' => 'required|integer',
            'age' => 'required|integer'
        ];
    }
}
