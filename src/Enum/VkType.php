<?php
namespace VipIpRuClient\Enum;

use MyCLabs\Enum\Enum;

/**
 * VkType enum
 */
class VkType extends Enum
{
    private const LIKE = 1;
    private const JOIN_GROUP = 2;
    private const SHARE_POST = 3;
    private const SHARE_GROUP = 7;
    private const CREATE_POST = 12432;
    private const SHARE_SITE = 57093;
    private const ADD_FRIENDS = 79987;
    private const VOTE = 91066;
    private const WATCH_VIDEO = 114260;
    private const WATCH_STREAM = 100864;
}