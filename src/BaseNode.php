<?php

namespace FSth\Picker;

abstract class BaseNode
{
    protected $url;
    protected $server;
    protected $idc;
    protected $tplKeys;

    public function __construct($url, $server, $idc = null)
    {
        $this->url = $url;
        $this->server = $server;
        $this->idc = $idc;

        $this->tplKeys = [
            'idc', 'url', 'outUrl', 'host', 'outHost'
        ];
    }

    public function setTplKeys(array $tplKeys)
    {
        $this->tplKeys = array_merge($tplKeys, $this->tplKeys);
    }

    abstract public function request();

    abstract protected function translate($node);

    protected function getValue(array $array, $index, $default = '')
    {
        return !empty($array[$index]) ? $array[$index] : $default;
    }

    protected function isHealth($node)
    {
        return ($node['status'] == 'health');
    }

    protected function health($nodes)
    {
        // TODO: Implement health() method.
        if (empty($nodes) || !is_array($nodes)) {
            return [];
        }
        $transportNodes = [];
        foreach ($nodes as $key => $node) {
            $transportNode = $this->translate($node);
            if (!empty($transportNode) && $this->isHealth($transportNode)) {
                $transportNodes[] = $transportNode;
            }
        }
        return $transportNodes;
    }
}