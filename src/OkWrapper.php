<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\OkType;

class OkWrapper extends SocialWrapper
{

    public function createJobJoinGroup($link, $name = "")
    {
        $type = OkType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'VK'." ".$name : 'VK';
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = OkType::LIKE()->getValue();
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
        $type = OkType::INSTALL_APP()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? 'VK'." ".$name : 'VK';
        return $this->createJob($service_name, $type, $params);
    }
}
