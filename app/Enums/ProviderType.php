<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProviderType extends Enum
{
    const USER =   "users";
    const SERVICE_PROVIDER =  'service-providers';
    const ADMIN = "admins";
}
