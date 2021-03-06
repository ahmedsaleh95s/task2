<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            //
            'name' => 'required|min:3|max:150',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users|regex:/^(0|\+)?(966|5|)(\d{9})$/',
            'password' => 'required|min:8',
            'photo' => 'required|file|mimes:jpeg,bmp,png'
        ];
    }
}
