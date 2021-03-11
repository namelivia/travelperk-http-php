<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Users;

use Carbon\Carbon;
use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Users\Users\Users;

class UsersQuery
{
    private $params;
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new UsersInputParams();
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

    public function get(): Users
    {
        return $this->execute(
            'get',
            implode('/', ['users']).'?'.$this->params->asUrlParam(),
            Users::class
        );
    }

    public function setTripId(string $tripId): UsersQuery
    {
        $this->params->setTripId($tripId);

        return $this;
    }

    public function setOffset(int $offset): UsersQuery
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit): UsersQuery
    {
        $this->params->setLimit($limit);

        return $this;
    }
}
