<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\InstaType;

class InstaWrapper extends SocialWrapper
{
    public function createJobLike($link, $name = "")
    {
        $type = InstaType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($name, $type, $params);
    }

    public function createJobSubscribe($link, $name = "")
    {
        $type = InstaType::SUBCRIBE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($name, $type, $params);
    }
}
