<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ReservationStatus extends Enum
{
    const NOT_RESERVED =   'NO';
    const  RESERVED =   'YES';
}
