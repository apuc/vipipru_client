<?php
namespace app\Wrapper\Enum;

use MyCLabs\Enum\Enum;

/**
 * BalanceType enum
 */
class BalanceType extends Enum
{
    private const VIEWS = \Vipip\Service\Social::BALANCE_TYPE_SHOWS;
    private const DAYS = \Vipip\Service\Social::BALANCE_TYPE_DAYS;
    private const MONEY = \Vipip\Service\Social::BALANCE_TYPE_MONEY;
}