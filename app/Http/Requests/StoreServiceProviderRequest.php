<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OverlapIntervals;

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
            'name_ar' => 'required|min:3|max:150',
            'name_en' => 'required|min:3|max:150',
            'phone' => ['required', 'regex:/^(0|\+)?(966|5|)(\d{9})$/'],
            'email' => 'required|email:rfc,dns|unique:service_providers',
            'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'], 
            'long' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'avatar' => 'required|image|mimes:jpeg,bmp,png',
            'files' => 'required|array',
            'files.*' => 'required|file',
            'Categories' => 'required|array',
            'Categories.*' => 'required|exists:categories,id',
            'Area_polygon' => 'required|array',
            'Area_polygon.*.0' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'Area_polygon.*.1' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'working_hours' => ['required','array'], // new OverlapIntervals
            'working_hours.*' => ['bail' , new OverlapIntervals],
            'working_hours.*.from' => ['required', 'date_format:h:i A'], // 
            'working_hours.*.to' => ['required','after:working_hours.*.from','date_format:h:i A'],
            'working_hours.*.day' => 'required|numeric|min:0|max:6',
            'allowed_time' => ['required','numeric'], // need extra validation
            'price' => 'required|numeric',
            'password' => 'required|min:8',
        ];
    }
}
