<?php

namespace app\Wrapper;

use app\Wrapper\Enum\BalanceType;
use app\Wrapper\Enum\TwitchType;
use app\Wrapper\Enum\VKType;
use Vipip\VipIP;

class VKWrapper
{
    /**
     * @var string Last error
     */
    private $error;

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @var \Vipip\Service\Social current job;
     */
    private $api_obj;

    /**
     * @param string $link Stream link
     */
    public function __construct()
    {
        $this->api_obj = null;
    }

    public function createJobJoinGroup($link, $name = "")
    {
        $type = VKType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = VKType::LIKE()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobShareWithFriends($link, $name = "")
    {
        $type = VKType::SHARE_POST()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobShareGroupWithFriends($link, $name = "")
    {
        $type = VKType::SHARE_GROUP()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobCreatePost($message, $name = "")
    {
        $type = VKType::CREATE_POST()->getValue();
        $params = ["message" => $message];
        return $this->createJob($name, $type, $params);
    }

    public function createJobShareSite($link, $name = "")
    {
        $type = VKType::SHARE_SITE()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobAddFriends($link, $name = "")
    {
        $type = VKType::ADD_FRIENDS()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobInstallApp($link, $name = "")
    {
        $type = VKType::INSTALL_APP()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobWatchVideo($link, $name = "")
    {
        $type = VKType::WATCH_VIDEO()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobWatchStream($link, $name = "")
    {
        $type = VKType::WATCH_STREAM()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    // must be called after getPollAnswers 'cause requires proper answerid and it ain't 1,2,3,4
    public function createJobVote($link, $answerid, $name = "")
    {
        $type = VKType::VOTE()->getValue();
        $params = ["url" => $link, 'answerid' => $answerid];
        return $this->createJob($name, $type, $params);
    }

    // was forced to rewrite like this because it doesn't werk with in-box getVkPollAnswers function
    public function getPollAnswers($link)
    {
        $base_link = 'https://vipip.ru/rest/social/pollvariants/?url=';
        $full_link = $base_link.$link;
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $full_link);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($handle);
        curl_close($handle);
        $result = json_decode($output);
        return $result;
    }

    private function createJob($name, $type, $params)
    {
        $service_name = $name == "" ? 'VK' . " " . $name : 'VK';
        $this->api_obj = VipIP::module('social')->create($service_name, $type, $params);
        return 1;
    }

    /**
     * @param integer $id Job ID, it's type must be one of the VK's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module('social')->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            if (in_array($tariff->id, VKType::values())) {
                $this->api_obj = $api_obj;
                //$this->link = $this->api_obj->getLinkId();
                return 1;
            } else {
                $this->error = "Last error: Job with {$id} is not Twitch job";
                return -1;
            }
        } else {
            $this->error = "Last error: Job with {$id} is not found";
            return -2;
        }
    }

    /**
     * @param integer $views Amount of views to cheat in currency
     * @param string $view_type Currency type
     */
    public function setJobViews($views, $view_type)
    {
        if ($this->api_obj) {
            if (!$this->api_obj->changeBalance($views, $view_type)) {
                $this->error = "Last error: " . $this->api_obj->getLastError() . PHP_EOL;
                return -1;
            } else {
                return 1;
            }
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    /**
     * @param string $status Disabled or enabled
     */
    public function setJobStatus($status)
    {
        if ($this->api_obj) {
            if (!$this->api_obj->changeStatus($status)) {
                $this->error = "Last error: " . $this->api_obj->getLastError() . PHP_EOL;
                return -1;
            } else {
                return 1;
            }
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // mb restructure following 3 funcs with builder pattern?
    public function setAge($min = 0, $max = 0) {
        $tariff = $this->api_obj->getTariff();
        $tariff->age_min = $min;
        $tariff->age_max = $max;
        $this->api_obj->setTariff($tariff);
    }

    public function setGender($gender) {
        $tariff = $this->api_obj->getTariff();
        $tariff->sex = $gender;
        $this->api_obj->setTariff($tariff);
    }

    public function setFriendsOptions($option_id) {
        $tariff = $this->api_obj->getTariff();
        $tariff->friends_id = $option_id;
        $this->api_obj->setTariff($tariff);
    }

    // TODO: add geography
    // TODO: add time (including time regions)
    // TODO: add referer and inputpoint interaction
    // TODO: most likely this will be in parent class along with setAge, setGender, setFriendsOptions, setJobViews\Status
    // 'cause it's common functionality

}
