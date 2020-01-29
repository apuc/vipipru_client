<?php

namespace app\Wrapper;

use app\Wrapper\Enum\BalanceType;
use app\Wrapper\Enum\LinksType;
use Vipip\VipIP;

class LinksWrapper extends BaseWrapper
{
    /**
     * @param $input_points array Array of strings, non-valid URLs will be ignored
     * @param $input_weights array Array, all values must be cast-able to integer
     */
    public function setInputPoints($input_points, $input_weights)
    {
        $count = count($input_points);
        if ($count == count($input_weights)) {
            if ($this->api_obj) {
                $inp_ref = $this->api_obj->getInputReferer();
                $inp_ref->clearInputpoint();
                foreach (range(0, $count) as $index) {
                    if (filter_input($input_points[$index], FILTER_VALIDATE_URL)) {
                        $inp_ref->addInputpoint($input_points[$index], $input_weights[$index]);
                    }
                }
                if(!$this->api_obj->setInputReferer($inp_ref)){
                    $this->error = "Last error: ".$this->api_obj->getLastError() . PHP_EOL;
                    return -3;
                }
            } else {
                $this->error = "Last error: no Job set";
                return -1;
            }
        } else {
            $this->error = "Last error: Size of points and weights arrays doesn't match";
            return -2;
        }
    }

    /**
     * @param $input_points array Array of strings, non-valid URLs will be ignored
     * @param $input_weights array Array, all values must be cast-able to integer
     */
    public function setReferer($input_points, $input_weights)
    {
        $count = count($input_points);
        if ($count == count($input_weights)) {
            if ($this->api_obj) {
                $inp_ref = $this->api_obj->getInputReferer();
                $inp_ref->clearReferer();
                foreach (range(0, $count) as $index) {
                    if (filter_input($input_points[$index], FILTER_VALIDATE_URL)) {
                        $inp_ref->addReferer($input_points[$index], $input_weights[$index]);
                    }
                }
                if(!$this->api_obj->setInputReferer($inp_ref)){
                    $this->error = "Last error: ".$this->api_obj->getLastError() . PHP_EOL;
                    return -3;
                }
            } else {
                $this->error = "Last error: no Job set";
                return -1;
            }
        } else {
            $this->error = "Last error: Size of points and weights arrays doesn't match";
            return -2;
        }
    }

    /**
     * @param integer $id Job ID, it's type must be one of the Twitch's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module($this->wrapper_type)->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            if (in_array($tariff->id, LinkType::values())) {
                $this->api_obj = $api_obj;
                return 1;
            } else {
                $this->error = "Last error: Job with {$id} is not Link job";
                return -1;
            }
        } else {
            $this->error = "Last error: Job with {$id} is not found";
            return -2;
        }
    }
}
