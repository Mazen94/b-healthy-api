<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;

class PaginationRequest extends FormRequest
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
            'page' => 'integer|min: ' . Config::get('constants.MIN_CURRENT_PAGE'),
            'perPage' => 'integer|min: ' . Config::get('constants.MIN_PER_PAGE'),
            'orderBy' => 'string',
            'orderDirection' => 'string',
            'search' => 'string'
        ];
    }
}
