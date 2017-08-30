<?php

class TestConsul extends PHPUnit_Framework_TestCase
{
    private $picker;

    private $url = '127.0.0.1:8500';
    private $server = 'liveHttp';
    private $idc = null;

    public function setUp()
    {
        parent::setUp();
        $this->picker = new \FSth\Picker\Picker();
        $node = new \FSth\Picker\Consul($this->url, $this->server, $this->idc);
        $node->setTplKeys(['sslUrl']);
        $this->picker->setMiddleWare($node);
    }

    public function testRequest()
    {
        $response = $this->picker->request();
        var_dump($response);
    }
}