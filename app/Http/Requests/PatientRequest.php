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
        return [
            'email' => 'required|string|email|unique:patients',
            'firstName' => 'required',
            'lastName' => 'required',
            'numberPhone' => 'required|string',
            'profession' => 'required|string',
            'gender' => 'required|integer',
        ];
    }
}
