<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PolygonPointsRule implements Rule
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
        $areaPolygonCount = count(request()->Area_polygon);
        if (request()->Area_polygon[0][0] != request()->Area_polygon[$areaPolygonCount- 1][0] || request()->Area_polygon[0][1] != request()->Area_polygon[$areaPolygonCount- 1][1]) {
            return false;
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
        return 'Start Points Must Equal End Points.';
    }
}
