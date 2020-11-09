<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceProviderRequest extends FormRequest
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
            'name_ar' => 'required',
            'name_en' => 'required',
            'phone' => ['required', 'regex:/^(0|\+)?(966|5|)(\d{9})$/'],
            'email' => 'required|email|unique:service_providers',
            'lat' => 'required',
            'long' => 'required',
            'avatar' => 'required|image|mimes:jpeg,bmp,png',
            'files' => 'required|array',
            'Categories' => 'required|array',
            'Area_polygon' => 'required|array|min:5',
            'working_hours' => 'required|array'

        ];
    }
}
