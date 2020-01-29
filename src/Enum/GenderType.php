<?php

namespace VipIpRuClient\Enum;

use MyCLabs\Enum\Enum;

/**
 * GenderType enum
 */
class GenderType extends Enum
{
    private const ANY = \Vipip\Service\Settings\SocialTariff::SEX_ANY;
    private const MALE = \Vipip\Service\Settings\SocialTariff::SEX_MALE;
    private const FEMALE = \Vipip\Service\Settings\SocialTariff::SEX_FEMALE;
}