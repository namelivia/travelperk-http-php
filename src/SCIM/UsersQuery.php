<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\Users\Users;

class UsersQuery
{
    private $params;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new UsersInputParams();
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

        //TODO: This won't go here. Ugly fix!
        $response = str_replace([
            '"urn:ietf:params:scim:schemas:extension:travelperk:2.0:User":',
            '"urn:ietf:params:scim:schemas:extension:enterprise:2.0:User":',
            '"$ref":',
        ], [
            '"travelperk_extension":',
            '"enterprise_extension":',
            '"ref":',
        ], $response);
        //TODO

        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    public function setCount(int $count): UsersQuery
    {
        $this->params->setCount($count);

        return $this;
    }

    public function setStartIndex(int $startIndex): UsersQuery
    {
        $this->params->setStartIndex($startIndex);

        return $this;
    }

    public function setFilter(string $filter): UsersQuery
    {
        $this->params->setFilter($filter);

        return $this;
    }

    public function get(): object
    {
        return $this->execute('get', implode('/', ['scim', 'Users']).'?'.$this->params->asUrlParam(), Users::class);
    }
}
