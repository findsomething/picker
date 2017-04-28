<?php

namespace FSth\Picker;

abstract class BaseNode
{
    protected $url;
    protected $server;
    protected $idc;

    abstract public function request();

    abstract protected function transport($node);

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
            $transportNode = $this->transport($node);
            if ($this->isHealth($transportNode)) {
                $transportNodes[] = $this->transport($node);
            }
        }
        return $transportNodes;
    }
}