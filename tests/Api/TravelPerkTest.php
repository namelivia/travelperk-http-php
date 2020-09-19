<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Client\Client;
use Namelivia\TravelPerk\Api\TravelPerk;
use Psr\Http\Message\ResponseInterface;

class TravelPerkTest extends TestCase
{
    private $client;
    private $travelPerk;

    public function setUp():void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
        $this->travelPerk = new TravelPerk($this->client, false);
        $this->responseMock = Mockery::mock(ResponseInterface::class);
    }

    public function testMakingAGetCall()
    {
        $this->client->shouldReceive('get')
            ->once()
            ->with('https://api.travelperk.com/sampleurl')
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $this->travelPerk->get('sampleurl')
        );
    }

    public function testMakingAJSONGetCall()
    {
        $this->client->shouldReceive('get')
            ->once()
            ->with('https://api.travelperk.com/sampleurl')
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('{"key" : "value"}');
        $this->assertEquals(
            'value',
            $this->travelPerk->getJson('sampleurl')->key
        );
    }

    public function testMakingAPostCall()
    {
        $this->client->shouldReceive('post')
            ->once()
            ->with('https://api.travelperk.com/sampleurl', ['json' => ['params']])
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $this->travelPerk->post('sampleurl', ['params'])
        );
    }

    public function testMakingAJSONPutCall()
    {
        $this->client->shouldReceive('put')
            ->once()
            ->with('https://api.travelperk.com/sampleurl', ['json' => ['params']])
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('{"key" : "value"}');
        $this->assertEquals(
            'value',
            $this->travelPerk->putJson('sampleurl', ['params'])->key
        );
    }

    public function testMakingAPatchCall()
    {
        $this->client->shouldReceive('patch')
            ->once()
            ->with('https://api.travelperk.com/sampleurl', ['json' => ['params']])
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $this->travelPerk->patch('sampleurl', ['params'])
        );
    }

    public function testMakingADeleteCall()
    {
        $this->client->shouldReceive('delete')
            ->once()
            ->with('https://api.travelperk.com/sampleurl')
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $this->travelPerk->delete('sampleurl')
        );
    }

    public function testGettingAnExpensesInstance()
    {
        $this->assertTrue($this->travelPerk->expenses() instanceof \Namelivia\TravelPerk\Api\Expenses);
    }

    public function testGettingASCIMInstance()
    {
        $this->assertTrue($this->travelPerk->scim() instanceof \Namelivia\TravelPerk\Api\SCIM);
    }

    public function testGettingAWebhooksInstance()
    {
        $this->assertTrue($this->travelPerk->webhooks() instanceof \Namelivia\TravelPerk\Api\WebhooksAPI);
    }

    public function testQueryingTheSandboxEnvironment()
    {
        $sandboxApi = new TravelPerk($this->client, true);
        $this->client->shouldReceive('get')
            ->once()
            ->with('https://sandbox.travelperk.com/sampleurl')
            ->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $sandboxApi->get('sampleurl')
        );
    }
}
