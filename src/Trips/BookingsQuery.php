<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use Carbon\Carbon;
use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Trips\Bookings\Bookings;

class BookingsQuery
{
    private $params;
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new BookingsInputParams();
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class)
    {
        $result = new $class();
        $response = $this->travelPerk->{$method}($url);
        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    public function get(): Bookings
    {
        return $this->execute(
            'get',
            implode('/', ['bookings']).'?'.$this->params->asUrlParam(),
            Bookings::class
        );
    }

    public function setTripId(string $tripId): BookingsQuery
    {
        $this->params->setTripId($tripId);

        return $this;
    }

    public function setStatus(string $status): BookingsQuery
    {
        $this->params->setStatus($status);

        return $this;
    }

    public function setType(string $type): BookingsQuery
    {
        $this->params->setType($type);

        return $this;
    }

    public function setModifiedLt(Carbon $modifiedLt): BookingsQuery
    {
        $this->params->setModifiedLt($modifiedLt);

        return $this;
    }

    public function setModifiedGte(Carbon $modifiedGte): BookingsQuery
    {
        $this->params->setModifiedLt($modifiedGte);

        return $this;
    }

    public function setOffset(int $offset): BookingsQuery
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit): BookingsQuery
    {
        $this->params->setLimit($limit);

        return $this;
    }
}
