<?php
namespace VipIpRuClient\Enum;

use MyCLabs\Enum\Enum;

/**
 * StatusType enum
 */
class StatusType extends Enum
{
    private const ENABLED = \Vipip\Service\Social::STATUS_ENABLED;
    private const DISABLED = \Vipip\Service\Social::STATUS_DISABLED;
}