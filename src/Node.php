<?php

namespace FSth\Picker;

class Node extends BaseNode
{
    protected $requestUrl = "%s/v1/nodes/%s/%s";

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
        return $this->health(json_decode($response->body, true));
    }

    public function transport($node)
    {
        // TODO: Implement transport() method.
        return [
            'server' => $this->server,
            'idc' => $this->getValue($node, 'Idc'),
            'type' => $this->getValue($node, 'Type'),
            'url' => $this->getValue($node, 'Url'),
            'outUrl' => $this->getValue($node, 'OutUrl'),
            'host' => $this->getValue($node, 'Host'),
            'outHost' => $this->getValue($node, 'OutHost'),
            'port' => $this->getValue($node, 'Port'),
            'status' => $this->getValue($node, 'Status')
        ];
    }
}