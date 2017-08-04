<?php

namespace FSth\Picker;

use SensioLabs\Consul\ServiceFactory;

class Consul extends BaseNode
{
    const NODE_CONTENT = 'nodes/%s/content';

    protected $sf;
    protected $kv;
    protected $health;

    public function __construct($url, $server, $idc = null)
    {
        $this->url = $url;
        $this->server = $server;
        $this->idc = $idc;
    }

    public function setIdc($idc)
    {
        $this->idc = $idc;
    }

    public function request()
    {
        $this->init();

        $services = $this->health->service($this->server, $this->getIdcSetting());
        $result = $this->health($services->json());

        $this->clear();

        return $result;
    }

    public function transport($node)
    {
        $check = count($node['Checks']) > 1 ? $node['Checks'][1] : $node['Checks'][0];
        if ($check['Status'] != 'passing') {
            return [];
        }
        $nodeKey = sprintf(self::NODE_CONTENT, $node['Service']['ID']);
        $nodeContent = json_decode($this->kv->get($nodeKey,
            array_merge(['raw' => true], $this->getIdcSetting()))->getBody(), true);
        // TODO: Implement transport() method.
        return [
            'server' => $this->server,
            'idc' => $this->getValue($nodeContent, 'idc'),
            'url' => $this->getValue($nodeContent, 'url'),
            'outUrl' => $this->getValue($nodeContent, 'outUrl'),
            'host' => $this->getValue($nodeContent, 'host'),
            'outHost' => $this->getValue($nodeContent, 'outHost'),
            'port' => $node['Service']['Port'],
            'status' => ($check['Status'] == 'passing') ? 'health' : 'unHealth'
        ];
    }

    protected function getIdcSetting()
    {
        return !empty($this->idc) ? ['dc' => $this->idc] : [];
    }

    protected function clear()
    {
        unset($this->sf);
        unset($this->health);
        unset($this->kv);
    }

    protected function init()
    {
        $this->sf = new ServiceFactory([
            'base_uri' => $this->url,
        ]);

        $this->kv = $this->sf->get('kv');

        $this->health = $this->sf->get('health');
    }

}