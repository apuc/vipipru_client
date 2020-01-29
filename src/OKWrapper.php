<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\OKType;

class OKWrapper extends SocialWrapper
{

    public function createJobJoinGroup($link, $name = "")
    {
        $type = OKType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'VK'." ".$name : 'VK';
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = OKType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'VK'." ".$name : 'VK';
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobShare($link, $name = "")
    {
        $type = VKType::SHARE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'VK'." ".$name : 'VK';
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobInstallApp($link, $name = "")
    {
        $type = OKType::INSTALL_APP()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? 'VK'." ".$name : 'VK';
        return $this->createJob($service_name, $type, $params);
    }
}
