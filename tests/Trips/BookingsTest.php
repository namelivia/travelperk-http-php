<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Trips\Bookings;

class BookingsTest extends TestCase
{
    private $travelPerk;
    private $bookings;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->bookings = new Bookings($this->travelPerk, $this->mapper);
    }

    private function assertEqualsBookingsStub($bookingsPage): void
    {
        $this->assertEquals(4, $bookingsPage->total);
        $this->assertEquals(0, $bookingsPage->offset);
        $this->assertEquals(10, $bookingsPage->limit);
        $this->assertEquals(4, count($bookingsPage->bookings));

        $this->assertEquals('71', $bookingsPage->bookings[0]->id);
        $this->assertEquals('2021-03-06T00:00:00+00:00', $bookingsPage->bookings[0]->start);
        $this->assertEquals('2021-03-07T00:00:00+00:00', $bookingsPage->bookings[0]->end);
        $this->assertEquals('hotel', $bookingsPage->bookings[0]->type);
        $this->assertEquals('ticketed', $bookingsPage->bookings[0]->status);
        $this->assertEquals('2021-01-04T11:11:20.714987+00:00', $bookingsPage->bookings[0]->modified);
        $this->assertEquals('51', $bookingsPage->bookings[0]->tripId);
        $this->assertEquals(1, count($bookingsPage->bookings[0]->references));
        $this->assertEquals('confirmation_number', $bookingsPage->bookings[0]->references[0]->type);
        $this->assertEquals('4636', $bookingsPage->bookings[0]->references[0]->value);
        $this->assertEquals('59.5468062', $bookingsPage->bookings[0]->location->latitude);
        $this->assertEquals('113.9913155', $bookingsPage->bookings[0]->location->longitude);
        $this->assertEquals(null, $bookingsPage->bookings[0]->location->iataCode);
        $this->assertEquals(null, $bookingsPage->bookings[0]->legs);

        $this->assertEquals('73', $bookingsPage->bookings[1]->id);
        $this->assertEquals('2021-03-06T00:00:00+00:00', $bookingsPage->bookings[1]->start);
        $this->assertEquals('2021-03-09T00:00:00+00:00', $bookingsPage->bookings[1]->end);
        $this->assertEquals('car', $bookingsPage->bookings[1]->type);
        $this->assertEquals('ticketed', $bookingsPage->bookings[1]->status);
        $this->assertEquals('2021-01-03T11:11:20.714987+00:00', $bookingsPage->bookings[1]->modified);
        $this->assertEquals('51', $bookingsPage->bookings[1]->tripId);
        $this->assertEquals(2, count($bookingsPage->bookings[1]->references));
        $this->assertEquals('voucher_code', $bookingsPage->bookings[1]->references[0]->type);
        $this->assertEquals('voucher_12', $bookingsPage->bookings[1]->references[0]->value);
        $this->assertEquals('confirmation_number', $bookingsPage->bookings[1]->references[1]->type);
        $this->assertEquals('cn_17', $bookingsPage->bookings[1]->references[1]->value);
        $this->assertEquals(-56.0, $bookingsPage->bookings[1]->location->latitude);
        $this->assertEquals(-62.0, $bookingsPage->bookings[1]->location->longitude);
        $this->assertEquals(null, $bookingsPage->bookings[1]->location->iataCode);
        $this->assertEquals(null, $bookingsPage->bookings[1]->location->legs);

        $this->assertEquals('70', $bookingsPage->bookings[2]->id);
        $this->assertEquals('2021-03-06T00:00:00+00:00', $bookingsPage->bookings[2]->start);
        $this->assertEquals('2021-03-07T00:00:00+00:00', $bookingsPage->bookings[2]->end);
        $this->assertEquals('flight', $bookingsPage->bookings[2]->type);
        $this->assertEquals('ticketed', $bookingsPage->bookings[2]->status);
        $this->assertEquals('2021-01-02T11:11:20.714987+00:00', $bookingsPage->bookings[2]->modified);
        $this->assertEquals('51', $bookingsPage->bookings[2]->tripId);
        $this->assertEquals(1, count($bookingsPage->bookings[2]->references));
        $this->assertEquals('PNR', $bookingsPage->bookings[2]->references[0]->type);
        $this->assertEquals('HNTCEBSMPO', $bookingsPage->bookings[2]->references[0]->value);
        $this->assertEquals(null, $bookingsPage->bookings[2]->location);
        $this->assertEquals(2, count($bookingsPage->bookings[2]->legs));
        $this->assertEquals(2, count($bookingsPage->bookings[2]->legs[0]->segments));
        $this->assertEquals(2, count($bookingsPage->bookings[2]->legs[1]->segments));
        $this->assertEquals('85.5975436', $bookingsPage->bookings[2]->legs[0]->segments[0]->origin->location->latitude);
        $this->assertEquals('18.7959996', $bookingsPage->bookings[2]->legs[0]->segments[0]->origin->location->longitude);
        $this->assertEquals('UYM', $bookingsPage->bookings[2]->legs[0]->segments[0]->origin->location->iataCode);
        $this->assertEquals('2021-03-06T00:00:00+01:00', $bookingsPage->bookings[2]->legs[0]->segments[0]->origin->time);
        $this->assertEquals('-54.3854772', $bookingsPage->bookings[2]->legs[0]->segments[0]->destination->location->latitude);
        $this->assertEquals('81.6402173', $bookingsPage->bookings[2]->legs[0]->segments[0]->destination->location->longitude);
        $this->assertEquals('EKD', $bookingsPage->bookings[2]->legs[0]->segments[0]->destination->location->iataCode);
        $this->assertEquals('2021-03-07T12:00:00+01:00', $bookingsPage->bookings[2]->legs[0]->segments[0]->destination->time);
        $this->assertEquals('XX1234', $bookingsPage->bookings[2]->legs[0]->segments[0]->externalId);
        $this->assertEquals('67.1291014', $bookingsPage->bookings[2]->legs[0]->segments[1]->origin->location->latitude);
        $this->assertEquals('21.1347543', $bookingsPage->bookings[2]->legs[0]->segments[1]->origin->location->longitude);
        $this->assertEquals('IWP', $bookingsPage->bookings[2]->legs[0]->segments[1]->origin->location->iataCode);
        $this->assertEquals('2021-03-08T00:00:00+01:00', $bookingsPage->bookings[2]->legs[0]->segments[1]->origin->time);
        $this->assertEquals('8.6677113', $bookingsPage->bookings[2]->legs[0]->segments[1]->destination->location->latitude);
        $this->assertEquals('-13.9691879', $bookingsPage->bookings[2]->legs[0]->segments[1]->destination->location->longitude);
        $this->assertEquals('TMQ', $bookingsPage->bookings[2]->legs[0]->segments[1]->destination->location->iataCode);
        $this->assertEquals('2021-03-09T12:00:00+01:00', $bookingsPage->bookings[2]->legs[0]->segments[1]->destination->time);
        $this->assertEquals('XX1234', $bookingsPage->bookings[2]->legs[0]->segments[1]->externalId);
        $this->assertEquals('23.5841460', $bookingsPage->bookings[2]->legs[1]->segments[0]->origin->location->latitude);
        $this->assertEquals('-141.9148137', $bookingsPage->bookings[2]->legs[1]->segments[0]->origin->location->longitude);
        $this->assertEquals('UJH', $bookingsPage->bookings[2]->legs[1]->segments[0]->origin->location->iataCode);
        $this->assertEquals('2021-03-10T12:00:00+01:00', $bookingsPage->bookings[2]->legs[1]->segments[0]->origin->time);
        $this->assertEquals('-6.0933315', $bookingsPage->bookings[2]->legs[1]->segments[0]->destination->location->latitude);
        $this->assertEquals('-7.6775088', $bookingsPage->bookings[2]->legs[1]->segments[0]->destination->location->longitude);
        $this->assertEquals('ZVO', $bookingsPage->bookings[2]->legs[1]->segments[0]->destination->location->iataCode);
        $this->assertEquals('2021-03-11T00:00:00+01:00', $bookingsPage->bookings[2]->legs[1]->segments[0]->destination->time);
        $this->assertEquals('XX1234', $bookingsPage->bookings[2]->legs[1]->segments[0]->externalId);
        $this->assertEquals('78.4132615', $bookingsPage->bookings[2]->legs[1]->segments[1]->origin->location->latitude);
        $this->assertEquals('-156.7342795', $bookingsPage->bookings[2]->legs[1]->segments[1]->origin->location->longitude);
        $this->assertEquals('OJR', $bookingsPage->bookings[2]->legs[1]->segments[1]->origin->location->iataCode);
        $this->assertEquals('2021-03-12T12:00:00+01:00', $bookingsPage->bookings[2]->legs[1]->segments[1]->origin->time);
        $this->assertEquals('-44.6617225', $bookingsPage->bookings[2]->legs[1]->segments[1]->destination->location->latitude);
        $this->assertEquals('163.2773819', $bookingsPage->bookings[2]->legs[1]->segments[1]->destination->location->longitude);
        $this->assertEquals('YNX', $bookingsPage->bookings[2]->legs[1]->segments[1]->destination->location->iataCode);
        $this->assertEquals('2021-03-13T00:00:00+01:00', $bookingsPage->bookings[2]->legs[1]->segments[1]->destination->time);
        $this->assertEquals('XX1234', $bookingsPage->bookings[2]->legs[1]->segments[1]->externalId);

        $this->assertEquals('72', $bookingsPage->bookings[3]->id);
        $this->assertEquals('2021-03-06T00:00:00+00:00', $bookingsPage->bookings[3]->start);
        $this->assertEquals('2021-03-07T00:00:00+00:00', $bookingsPage->bookings[3]->end);
        $this->assertEquals('train', $bookingsPage->bookings[3]->type);
        $this->assertEquals('ticketed', $bookingsPage->bookings[3]->status);
        $this->assertEquals('2021-01-01T11:11:20.714987+00:00', $bookingsPage->bookings[3]->modified);
        $this->assertEquals('51', $bookingsPage->bookings[3]->tripId);
        $this->assertEquals(1, count($bookingsPage->bookings[3]->references));
        $this->assertEquals('ticket_collection_reference', $bookingsPage->bookings[3]->references[0]->type);
        $this->assertEquals('PMXFIQ', $bookingsPage->bookings[3]->references[0]->value);
        $this->assertEquals(null, $bookingsPage->bookings[3]->location);
        $this->assertEquals(1, count($bookingsPage->bookings[3]->legs));
        $this->assertEquals(1, count($bookingsPage->bookings[3]->legs[0]->segments));
        $this->assertEquals('-73.000000000', $bookingsPage->bookings[3]->legs[0]->segments[0]->origin->location->latitude);
        $this->assertEquals('-26.000000000', $bookingsPage->bookings[3]->legs[0]->segments[0]->origin->location->longitude);
        $this->assertEquals(null, $bookingsPage->bookings[3]->legs[0]->segments[0]->origin->location->iataCode);
        $this->assertEquals('2021-03-06T00:00:00+00:00', $bookingsPage->bookings[3]->legs[0]->segments[0]->origin->time);
        $this->assertEquals('-30.000000000', $bookingsPage->bookings[3]->legs[0]->segments[0]->destination->location->latitude);
        $this->assertEquals('83.000000000', $bookingsPage->bookings[3]->legs[0]->segments[0]->destination->location->longitude);
        $this->assertEquals(null, $bookingsPage->bookings[3]->legs[0]->segments[0]->destination->location->iataCode);
        $this->assertEquals('2021-03-09T00:00:00+00:00', $bookingsPage->bookings[3]->legs[0]->segments[0]->destination->time);
        $this->assertEquals('XX1234', $bookingsPage->bookings[3]->legs[0]->segments[0]->externalId);
    }

    public function testGettingAllBookingsWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('bookings?offset=5&limit=10')
            ->andReturn(file_get_contents('tests/stubs/bookings.json'));
        $bookings = $this->bookings->query()
             ->setOffset(5)
             ->setLimit(10)
             ->get();
        $this->assertEqualsBookingsStub($bookings);
    }

    public function testGettingStatuses()
    {
        $this->assertEquals(
            [
                'confirmed',
                'cancelled',
            ],
            $this->bookings->statuses()
        );
    }

    public function testGettingTypes()
    {
        $this->assertEquals(
            [
                'flight',
                'hotel',
                'train',
                'car',
                'other',
            ],
            $this->bookings->types()
        );
    }
}
