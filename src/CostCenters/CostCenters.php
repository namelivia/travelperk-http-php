<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\CostCenters\CostCenters\BulkUpdateResponse;
use Namelivia\TravelPerk\CostCenters\CostCenters\CostCenterDetail;
use Namelivia\TravelPerk\CostCenters\CostCenters\CostCenters as CostCentersType;

class CostCenters
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
     * List all cost centers.
     */
    public function all(): CostCentersType
    {
        return $this->execute('get', implode('/', ['cost_centers']), CostCentersType::class);
    }

    /**
     * Get cost center detail.
     */
    public function get(string $id): CostCenterDetail
    {
        return $this->execute('get', implode('/', ['cost_centers', $id]), CostCenterDetail::class);
    }

    /**
     * Update an existing cost center.
     */
    public function update(string $id, UpdateCostCenterInputParams $params): CostCenterDetail
    {
        return $this->execute('patch', implode('/', ['cost_centers', $id]), CostCenterDetail::class, $params->asArray());
    }

    /**
     * Bulk update an several cost centers at once.
     */
    public function bulkUpdate(BulkUpdateCostCenterInputParams $params): BulkUpdateResponse
    {
        return $this->execute('patch', implode('/', ['cost_centers', 'bulk_update']), BulkUpdateResponse::class, $params->asArray());
    }

    /**
     * Set the users for a cost center.
     */
    public function setUsers(string $id, SetUsersForCostCenterInputParams $params): CostCenterDetail
    {
        return $this->execute('put', implode('/', ['cost_centers', $id, 'users']), CostCenterDetail::class, $params->asArray());
    }
}