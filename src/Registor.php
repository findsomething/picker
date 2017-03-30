<?php

namespace FSth\Picker;

use anlutro\cURL\cURL;

class Registor
{
    protected $requestUrl = "%s/v1/nodes/%s/%s";

    protected $url;
    protected $server;
    protected $idc;

    public function __construct($url, $server, $idc)
    {
        $this->url = $url;
        $this->server = $server;
        $this->idc = $idc;
    }

    public function request()
    {
        $url = sprintf($this->requestUrl, $this->url, $this->idc, $this->server);
        $curl = new cURL();
        $response = $curl->get($url);
        return json_decode($response->body, true);
    }
}