<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\CostCenters\CostCenters\CostCenterDetail;
use JsonMapper\JsonMapper;

class UpdateCostCenterRequest
{
    private $params;
    private $travelPerk;
    private $id;
    private $mapper;

    public function __construct(string $id, TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->id = $id;
        $this->params = new UpdateCostCenterInputParams();
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
            'patch',
            implode('/', ['cost_centers', $this->id]),
            CostCenterDetail::class,
            $this->params->asArray()
        );
    }

    public function setName(string $name): UpdateCostCenterRequest
    {
        $this->params->setName($name);

        return $this;
    }

    public function setArchive(bool $archive): UpdateCostCenterRequest
    {
        $this->params->setArchive($archive);

        return $this;
    }
}
