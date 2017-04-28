<?php

namespace FSth\Picker;

use SensioLabs\Consul\ServiceFactory;

class Consul extends BaseNode
{
    const NODE_CONTENT = 'nodes/%s/content';

    private $sf;
    private $kv;
    private $health;

    public function __construct($url, $server, $idc)
    {
        $this->sf = new ServiceFactory([
            'base_uri' => $url
        ]);

        $this->kv = $this->sf->get('kv');

        $this->health = $this->sf->get('health');

        $this->url = $url;
        $this->server = $server;
        $this->idc = $idc;

    }

    public function request()
    {
        $services = $this->health->service($this->server);
        return $this->health($services->json());
    }

    public function transport($node)
    {
        $nodeKey = sprintf(self::NODE_CONTENT,  $node['Service']['ID']);
        $nodeContent = json_decode($this->kv->get($nodeKey, ['raw' => true])->getBody(),true);
        // TODO: Implement transport() method.
        return [
            'server' => $this->server,
            'idc' => $this->getValue($nodeContent, 'idc'),
            'url' => $this->getValue($nodeContent, 'url'),
            'outUrl' => $this->getValue($nodeContent, 'outUrl'),
            'host' => $this->getValue($nodeContent, 'host'),
            'outHost' => $this->getValue($nodeContent, 'outHost'),
            'port' => $node['Service']['Port'],
            'status' => ($node['Checks'][0]['Status'] == 'passing') ? 'health' : 'unHealth'
        ];
    }
}