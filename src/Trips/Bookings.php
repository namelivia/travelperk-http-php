<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;

class Bookings
{
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class, array $params = null)
    {
        $result = new $class();
        if (is_null($params)) {
            $response = $this->travelPerk->{$method}($url);
        } else {
            $response = $this->travelPerk->{$method}($url, $params);
        }
        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    /**
     * Query bookings.
     */
    public function query(): BookingsQuery
    {
        return new BookingsQuery($this->travelPerk, $this->mapper);
    }
}
