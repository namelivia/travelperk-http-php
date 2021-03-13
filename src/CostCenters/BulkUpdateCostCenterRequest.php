<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use Namelivia\TravelPerk\Api\TravelPerk;

class BulkUpdateCostCenterRequest
{
    private $params;
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->params = new BulkUpdateCostCenterInputParams();
        $this->travelPerk = $travelPerk;
    }

    public function save(): object
    {
        return json_decode($this->travelPerk->patch(implode('/', ['cost_centers', 'bulk_update']), $this->params->asArray()));
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
