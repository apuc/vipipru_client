<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\FBType;

class FBWrapper extends SocialWrapper
{

    public function createJobJoinGroup($link, $name = "")
    {
        $type = FBType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLikePage($link, $name = "")
    {
        $type = FBType::LIKE_PAGE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobShare($link, $name = "")
    {
        $type = FBType::SHARE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobAddFriend($link, $name = "")
    {
        $type = FBType::ADD_FRIEND()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = FBType::LIKE()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }
}
