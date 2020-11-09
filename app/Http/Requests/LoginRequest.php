<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
        $rule = (is_numeric($this->email)) ? 'regex:/^(0|\+)?(966|5|)(\d{9})$/' : 'email:rfc,dns';
        return [
            //
            "email" => ['required',  $rule],
            'password' => 'required'
        ];
    }
}
