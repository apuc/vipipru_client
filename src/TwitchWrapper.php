<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\TwitchType;

class TwitchWrapper extends SocialWrapper
{
    /**
     * @param string $name Custom string to append to service name
     */
    public function createJobWatch($link, $name = "")
    {
        $type = TwitchType::WATCH()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name . " " . $name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }
}
