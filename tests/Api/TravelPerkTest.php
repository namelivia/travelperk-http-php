<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Client\Client;
use Namelivia\TravelPerk\Api\TravelPerk;

class TravelPerkTest extends TestCase
{
    private $client;
    private $travelPerk;

    public function setUp():void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
        $this->travelPerk = new TravelPerk($this->client);
    }

    public function testMakingAGetCall()
    {
        $this->client->shouldReceive('get')
            ->once()
            ->with('https://api.travelperk.com/sampleurl')
            ->andReturn($this->client);
        $this->client->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $this->travelPerk->get('sampleurl')
        );
    }

    public function testMakingAPostCall()
    {
        $this->client->shouldReceive('post')
            ->once()
            ->with('https://api.travelperk.com/sampleurl')
            ->andReturn($this->client);
        $this->client->shouldReceive('getBody->getContents')
            ->once()
            ->with()
            ->andReturn('responseContent');
        $this->assertEquals(
            'responseContent',
            $this->travelPerk->post('sampleurl')
        );
    }

    public function testMakingADeleteCall()
    {
        $this->client->shouldReceive('delete')
            ->once()
            ->with('https://api.travelperk.com/sampleurl')
            ->andReturn($this->client);
        $this->client->shouldReceive('getBody->getContents')
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
}
