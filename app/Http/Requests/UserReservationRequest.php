<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserReservationRequest extends FormRequest
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
            'from' => ['required', 'date_format:h:i A'],
            'to' => ['required','after:from','date_format:h:i A'],
            'day' => 'required|numeric|min:0|max:6',
        ];
    }
}
