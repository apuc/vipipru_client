<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\FbType;

class FbWrapper extends SocialWrapper
{

    public function createJobJoinGroup($link, $name = "")
    {
        $type = FbType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLikePage($link, $name = "")
    {
        $type = FbType::LIKE_PAGE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobShare($link, $name = "")
    {
        $type = FbType::SHARE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobAddFriend($link, $name = "")
    {
        $type = FbType::ADD_FRIEND()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = FbType::LIKE()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }
}
