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
        return $this->travelPerk->patchJson(implode('/', ['cost_centers', 'bulk_update']), $this->params->asArray());
    }

    public function addId(int $id): BulkUpdateCostCenterRequest
    {
        $this->params->addId($id);

        return $this;
    }

    public function setArchive(bool $archive): BulkUpdateCostCenterRequest
    {
        $this->params->setArchive($archive);

        return $this;
    }
}
