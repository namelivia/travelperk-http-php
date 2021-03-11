<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\JsonMapper;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Api\TripsAPI;

class TripsAPITest extends TestCase
{
    private $travelPerk;
    private $trips;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->trips = new TripsAPI($this->travelPerk, Mockery::mock(JsonMapper::class));
    }

    public function testGettingATripsInstance()
    {
        $this->assertTrue($this->trips->trips() instanceof \Namelivia\TravelPerk\Trips\Trips);
    }
}
