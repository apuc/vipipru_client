<?php

namespace app\Wrapper\Enum;

use MyCLabs\Enum\Enum;

/**
 * TwitchType enum
 */
class GenderType extends Enum
{
    private const ANY = \Vipip\Service\Settings\SocialTariff::SEX_ANY;
    private const MALE = \Vipip\Service\Settings\SocialTariff::SEX_MALE;
    private const FEMALE = \Vipip\Service\Settings\SocialTariff::SEX_FEMALE;
}