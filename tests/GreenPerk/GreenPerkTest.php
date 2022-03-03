<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\GreenPerk\GreenPerk;

class GreenPerkTest extends TestCase
{
    private $travelPerk;
    private $greenPerk;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->greenPerk = new GreenPerk($this->travelPerk, $this->mapper);
    }

    public function testGettingFlightEmissions()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with(
                'emissions/flight?'.
                'origin=ES&destination=FR&cabin_class=economy&airline_code=LHR'
            )
            ->andReturn(file_get_contents('tests/stubs/emissions.json'));
        $emissions = $this->greenPerk->flightEmissions(
            'ES',
            'FR',
            'economy',
            'LHR'
        );
        $this->assertEquals(21, $emissions->emissions->co2eKg);
        $this->assertEquals(200, $emissions->distanceKm);
    }

    public function testGettingTrainEmissions()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with(
                'emissions/train?'.
                'origin_id=c44ba069-4109-4b40-815c-bf519c2c2844&destination_id=637d125e-9d00-478a-822c-e60c6e219227&vendor=eurostar'
            )
            ->andReturn(file_get_contents('tests/stubs/emissions.json'));
        $emissions = $this->greenPerk->trainEmissions(
            'c44ba069-4109-4b40-815c-bf519c2c2844',
            '637d125e-9d00-478a-822c-e60c6e219227',
            'eurostar'
        );
        $this->assertEquals(21, $emissions->emissions->co2eKg);
        $this->assertEquals(200, $emissions->distanceKm);
    }

    public function testGettingCarEmissions()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with(
                'emissions/car?'.
                'acriss_code=MCFD&num_days=2&distance_per_day=100'
            )
            ->andReturn(file_get_contents('tests/stubs/emissions.json'));
        $emissions = $this->greenPerk->carEmissions(
            'MCFD',
            2,
            100
        );
        $this->assertEquals(21, $emissions->emissions->co2eKg);
        $this->assertEquals(200, $emissions->distanceKm);
    }

    public function testGettingHotelEmissions()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with(
                'emissions/hotel?'.
                'country_code=ES&num_nights=2'
            )
            ->andReturn(file_get_contents('tests/stubs/hotel_emissions.json'));
        $emissions = $this->greenPerk->hotelEmissions(
            'ES',
            2
        );
        $this->assertEquals(21, $emissions->emissions->co2eKg);
    }
}
