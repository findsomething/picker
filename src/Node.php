<?php

namespace FSth\Picker;

class Node extends BaseNode
{
    protected $requestUrl = "%s/v1/nodes/%s/%s";

    protected $curl;

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

    public function translate($node)
    {
        // TODO: Implement translate() method.
        return $this->getTranslate($node);
    }

    protected function getTranslate($nodeContent, $status = 'health')
    {
        $result = [
            'server' => $this->server,
            'status' => $this->getValue($nodeContent, 'Status')
        ];
        foreach ($this->tplKeys as $key) {
            $result[$key] = $this->getValue($nodeContent, ucfirst($key));
        }
        return $result;
    }
}