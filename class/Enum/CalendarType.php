<?php
namespace app\Wrapper\Enum;

use MyCLabs\Enum\Enum;

/**
 * CalendarType enum
 */
class CalendarType extends Enum
{
    private const WEEK = \Vipip\Service\Settings\Calendar::TYPE_WEEK;
    private const MONTH = \Vipip\Service\Settings\Calendar::TYPE_MONTH;
}