<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class NutritionistRequest extends FormRequest
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

        if ($this->route()->getName() == 'registerNutritionist') {
            return [
                'email' => 'required|string|email|unique:nutritionists',
                'firstName' => 'required|string',
                'password' => 'required|min:' . Config::get('constants.MIN_PASSWORD_LENGTH') . '|max:' . Config::get(
                        'constants.MAX_PASSWORD_LENGTH'
                    ),
                'lastName' => 'required|string',
            ];
        } else {
            $user = auth()->user();
            return [
                'email' => [
                    'required',
                    Rule::unique('nutritionists', 'email')->ignore($user->id)
                ],
                'firstName' => 'required|string',
                'password' => 'required|min:' . Config::get('constants.MIN_PASSWORD_LENGTH') . '|max:' . Config::get(
                        'constants.MAX_PASSWORD_LENGTH'
                    ),
                'lastName' => 'required|string',
            ];
        }
    }

}
