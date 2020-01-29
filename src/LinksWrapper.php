<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\LinksType;

class LinksWrapper extends BaseWrapper
{
    public function createJobVIP($link, $name = "")
    {
        $type = LinksType::VIP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($name, $type, $params);
    }

    public function createJobStandart($link, $name = "")
    {
        $type = LinksType::STANDART()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($name, $type, $params);
    }

    public function createJobHit($link, $name = "")
    {
        $type = LinksType::HIT()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($name, $type, $params);
    }

    public function createJobLite($link, $name = "")
    {
        $type = LinksType::LITE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($name, $type, $params);
    }

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
    public function setReferers($input_points, $input_weights)
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

    // TODO: additional link functionality not implemented as per here https://vipip.ru/help/serfing.html
}
