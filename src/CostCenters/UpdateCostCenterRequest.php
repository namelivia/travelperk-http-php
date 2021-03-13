<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use Namelivia\TravelPerk\Api\TravelPerk;

class UpdateCostCenterRequest
{
    private $params;
    private $travelPerk;
    private $id;

    public function __construct(string $id, TravelPerk $travelPerk)
    {
        $this->id = $id;
        $this->params = new UpdateCostCenterInputParams();
        $this->travelPerk = $travelPerk;
    }

    public function save(): object
    {
        return $this->travelPerk->patchJson(implode('/', ['cost_centers', $this->id]), $this->params->asArray());
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
