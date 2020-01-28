<?php

namespace app\Wrapper;

use app\Wrapper\Enum\BalanceType;
use app\Wrapper\Enum\TwitchType;
use Vipip\VipIP;

class TwitchWrapper
{
    /**
     * @var string Stream link
     */
    private $link;
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
    public function __construct($link = null)
    {
        $this->link = $link;
        $this->api_obj = null;
    }

    /**
     * @param string $name Custom string to append to service name
     */
    public function createJobWatch($name = "")
    {
        if ($this->link) {
            $params = ['url' => $this->link];
            $service_name = $name == "" ? 'Twitch'." ".$name : 'Twitch';
            return $this->createJob($name, TwitchType::WATCH()->value(), $params);
        } else {
            $this->error = "Link is not set";
            return -1;
        }
    }

    private function createJob($name, $type, $params)
    {
        $this->api_obj = VipIP::module('social')->create($name, $type, $params);
        return 1;
    }

    public function reGetCurrentJob()
    {
        $id = $this->api_obj->getLinkid();
        $this->getJob($id);
    }
    /**
     * @param integer $id Job ID, it's type must be one of the Twitch's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module('social')->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            if (in_array($tariff->id, TwitchType::values())) {
                $this->api_obj = $api_obj;
                $this->link = $this->api_obj->getLink();
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
            if( !$this->api_obj->changeBalance($views, $view_type) ){
                $this->error = "Last error: ".$this->api_obj->getLastError().PHP_EOL;
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
            if(!$this->api_obj->changeStatus($status)){
                $this->error = "Last error: ".$this->api_obj->getLastError().PHP_EOL;
                return -1;
            } else {
                return 1;
            }
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // TODO: add geography and time
    // TODO: add friends options
    // TODO: add gender and age
}
