<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;

class Trips
{
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    /**
     * Query trips.
     */
    public function query(): TripsQuery
    {
        return new TripsQuery($this->travelPerk, $this->mapper);
    }

    /**
     * Get all statuses.
     */
    public function statuses(): array
    {
        return Status::getConstantValues();
    }
}
