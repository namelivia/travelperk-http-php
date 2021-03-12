<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Trips\Bookings;
use Namelivia\TravelPerk\Trips\Trips;

class TripsAPI
{
    private $trips;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->trips = new Trips($travelPerk, $mapper);
        $this->bookings = new Bookings($travelPerk, $mapper);
    }

    public function trips(): Trips
    {
        return $this->trips;
    }

    public function bookings(): Bookings
    {
        return $this->bookings;
    }
}
