<?php

namespace FSth\Picker;

use SensioLabs\Consul\ServiceFactory;

class Consul extends BaseNode
{
    const NODE_CONTENT = 'nodes/%s/content';

    protected $sf;
    protected $kv;
    protected $health;

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

    public function translate($node)
    {
        $check = count($node['Checks']) > 1 ? $node['Checks'][1] : $node['Checks'][0];
        if ($check['Status'] != 'passing') {
            return [];
        }
        $nodeKey = sprintf(self::NODE_CONTENT, $node['Service']['ID']);
        $nodeContent = json_decode($this->kv->get($nodeKey,
            array_merge(['raw' => true], $this->getIdcSetting()))->getBody(), true);
        $status = ($check['Status'] == 'passing') ? 'health' : 'unHealth';
        return $this->getTranslate($nodeContent, $status);
    }

    protected function getTranslate($nodeContent, $status = 'health')
    {
        $result = [
            'server' => $this->server,
            'status' => $status
        ];
        foreach ($this->tplKeys as $key) {
            $result[$key] = $this->getValue($nodeContent, $key);
        }
        return $result;
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