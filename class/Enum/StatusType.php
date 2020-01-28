<?php
namespace app\Wrapper\Enum;

use MyCLabs\Enum\Enum;

/**
 * BalanceType enum
 */
class StatusType extends Enum
{
    private const ENABLED = \Vipip\Service\Social::STATUS_ENABLED;
    private const DISABLED = \Vipip\Service\Social::STATUS_DISABLED;
}