<?php

namespace app\Wrapper\Request;


class Request
{
    private $link;
    private $handle;
    private $params;

    public function __construct()
    {
        $this->handle = curl_init();
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        $this->link = "";
        $this->params = array();
    }

    public function setLink($link)
    {
        if (filter_var($link, FILTER_VALIDATE_URL)) {
            $this->link = $link;
        }
    }

    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @param $array array Should have named indexes
     */
    public function setParamArray($array)
    {
        foreach ($array as $index => $item) {
            $this->params[$index] = $item;
        }
    }

    public function clearParams()
    {
        $this->params = array();
    }

    public function get()
    {
        if (!empty($this->link)) {
            if (!empty($this->params)) {
                $params = http_build_query($this->params);
                $url = $this->link . '?' . $params;
            } else {
                $url = $this->link;
            }
            curl_setopt($this->handle, CURLOPT_URL, $url);
            curl_setopt($this->handle, CURLOPT_HTTPGET, true);
            $output = curl_exec($this->handle);
            $result = json_decode($output);
            return $result;
        }
        return null;
    }

    public function  __destruct()
    {
        curl_close($this->handle);
        unset($this->handle);
        unset($this->params);
        unset($this->link);
    }
}