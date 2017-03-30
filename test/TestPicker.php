<?php

class TestPicker extends \PHPUnit_Framework_TestCase
{
    private $picker;

    private $url = '127.0.0.1:10000';
    private $server = 'logicHttpRpc';
    private $idc = 'local';

    public function setUp()
    {
        parent::setUp();
        $this->picker = new \FSth\Picker\Picker();
        $registor = new \FSth\Picker\Registor($this->url, $this->server, $this->idc);
        $this->picker->setMiddleWare($registor);
    }

    public function testRequest()
    {
        $response = $this->picker->request();
        $this->assertNotEmpty($response);
    }
}