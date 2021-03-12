<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Trips\Trips;

class TripsTest extends TestCase
{
    private $travelPerk;
    private $trips;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->trips = new Trips($this->travelPerk, $this->mapper);
    }

    private function assertEqualsTripsStub($tripsPage): void
    {
        $this->assertEquals(2, $tripsPage->total);
        $this->assertEquals(0, $tripsPage->offset);
        $this->assertEquals(10, $tripsPage->limit);
        $this->assertEquals(2, count($tripsPage->trips));
        $this->assertEquals('172', $tripsPage->trips[0]->id);
        $this->assertEquals('The Great Voyage', $tripsPage->trips[0]->tripName);
        $this->assertEquals('2020-11-20T00:00:00', $tripsPage->trips[0]->start);
        $this->assertEquals('2020-11-25T00:00:00', $tripsPage->trips[0]->end);
        $this->assertEquals('booked', $tripsPage->trips[0]->status);
        $this->assertEquals('2020-09-16T07:08:06.290253+00:00', $tripsPage->trips[0]->modified);
        $this->assertEquals('205', $tripsPage->trips[1]->id);
        $this->assertEquals('Road trip Barcelona', $tripsPage->trips[1]->tripName);
        $this->assertEquals('2020-09-25T10:00:00+00:00', $tripsPage->trips[1]->start);
        $this->assertEquals('2020-09-26T10:00:00+00:00', $tripsPage->trips[1]->end);
        $this->assertEquals('booked', $tripsPage->trips[1]->status);
        $this->assertEquals('2020-09-14T12:55:06.720754+00:00', $tripsPage->trips[1]->modified);
    }

    public function testGettingAllTripsWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('trips?offset=5&limit=10')
            ->andReturn(file_get_contents('tests/stubs/trips.json'));
        $trips = $this->trips->query()
             ->setOffset(5)
             ->setLimit(10)
             ->get();
        $this->assertEqualsTripsStub($trips);
    }
}
