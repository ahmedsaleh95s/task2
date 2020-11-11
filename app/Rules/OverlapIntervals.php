<?php

namespace App\Rules;

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
    public function passes($attribute, $value)
    {
        //
        for ($i=0; $i < count($value); $i++) {
            for ($j=$i + 1; $j < count($value); $j++) { 
                if ($value[$i]['to'] > $value[$j]['from'] && $value[$i]['day'] == $value[$j]['day']) {
                    return false;
                }
            }
        }
        return true;
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
