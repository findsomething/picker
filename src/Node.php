<?php

namespace FSth\Picker;

class Node
{
    protected $requestUrl = "%s/v1/nodes/%s/%s";

    protected $url;
    protected $server;
    protected $idc;
    protected $curl;

    public function __construct($url, $server, $idc)
    {
        $this->url = $url;
        $this->server = $server;
        $this->idc = $idc;
    }

    public function setCurl($curl)
    {
        $this->curl = $curl;
    }

    public function request()
    {
        $url = sprintf($this->requestUrl, $this->url, $this->idc, $this->server);
        $response = $this->curl->get($url);
        return $response;
    }
}