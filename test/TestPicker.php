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
        $node = new \FSth\Picker\Node($this->url, $this->server, $this->idc);

        $response = new stdClass();
        $response->body = ['hehe'];
        $curl = Mockery::mock('cURL');
        $curl->shouldReceive('get')
            ->withAnyArgs()
            ->andReturn($response);

        $node->setCurl($curl);
        $this->picker->setMiddleWare($node);
    }

    public function testRequest()
    {
        $response = $this->picker->request();
        $this->assertNotEmpty($response);
    }
}