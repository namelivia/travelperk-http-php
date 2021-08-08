<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\CostCenters\CostCenters\CostCenterDetail;

class SetUsersForCostCenterRequest
{
    private $params;
    private $travelPerk;
    private $id;
    private $mapper;

    public function __construct(string $id, TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new SetUsersForCostCenterInputParams();
        $this->id = $id;
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

    public function save(): object
    {
        return $this->execute(
            'put',
            implode('/', ['cost_centers', $this->id, 'users']),
            CostCenterDetail::class,
            $this->params->asArray()
        );
    }

    public function setIds(array $ids): SetUsersForCostCenterRequest
    {
        $this->params->setIds($ids);

        return $this;
    }
}
