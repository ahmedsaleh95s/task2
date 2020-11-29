<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'from' => ['required', 'date', 'date_format:Y-m-d h:i A'],
            'to' => ['required', 'after:from','date', 'date_format:Y-m-d h:i A', function ($attribute, $value, $fail){
                if (Carbon::parse($this->from)->addMinutes($this->serviceProvider->allowed_time)->format('Y-m-d h:i A') < $this->to) {
                    $fail($attribute.' is invalid.');
                };
            }],
        ];
    }
}
