<?php

namespace App\Rules;
use Illuminate\Support\Arr;

use Illuminate\Contracts\Validation\Rule;

class OverlapIntervals implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($key, $current)
    {
        //
        $array = Arr::where(request()->input('working_hours'), function ($value, $index) use($key, $current){
            if ($value) {
            return $value['day'] == $current['day'] && $value['to'] > $current['to'] && $current['to'] > $value['from'];
            }
        });
        return (count($array) == 0) ? true : false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be not in this interval.';
    }
}
