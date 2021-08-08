<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\CostCenters\CostCenters\BulkUpdateResponse;

class BulkUpdateCostCenterRequest
{
    private $params;
    private $travelPerk;
    private $mapper;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new BulkUpdateCostCenterInputParams();
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
            implode('/', ['cost_centers', 'bulk_update']),
            BulkUpdateResponse::class,
            $this->params->asArray()
        );
    }

    public function setIds(array $ids): BulkUpdateCostCenterRequest
    {
        $this->params->setIds($ids);

        return $this;
    }

    public function setArchive(bool $archive): BulkUpdateCostCenterRequest
    {
        $this->params->setArchive($archive);

        return $this;
    }
}
