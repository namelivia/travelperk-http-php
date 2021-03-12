<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use Carbon\Carbon;
use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Trips\Trips\Trips;

class TripsQuery
{
    private $params;
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new TripsInputParams();
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

    public function get(): Trips
    {
        return $this->execute(
            'get',
            implode('/', ['trips']).'?'.$this->params->asUrlParam(),
            Trips::class
        );
    }

    public function setStatus(string $status): TripsQuery
    {
        $this->params->setStatus($status);

        return $this;
    }

    public function setModifiedLt(Carbon $modifiedLt): TripsQuery
    {
        $this->params->setModifiedLt($modifiedLt);

        return $this;
    }

    public function setModifiedGte(Carbon $modifiedGte): TripsQuery
    {
        $this->params->setModifiedLt($modifiedGte);

        return $this;
    }

    public function setOffset(int $offset): TripsQuery
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit): TripsQuery
    {
        $this->params->setLimit($limit);

        return $this;
    }
}
