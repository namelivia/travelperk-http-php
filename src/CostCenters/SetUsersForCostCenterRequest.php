<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

use Namelivia\TravelPerk\Api\TravelPerk;

class SetUsersForCostCenterRequest
{
    private $params;
    private $travelPerk;
    private $id;

    public function __construct(string $id, TravelPerk $travelPerk)
    {
        $this->params = new SetUsersForCostCenterInputParams();
        $this->id = $id;
        $this->travelPerk = $travelPerk;
    }

    public function save(): object
    {
        return $this->travelPerk->putJson(implode('/', ['cost_centers', $this->id, 'users']), $this->params->asArray());
    }

    public function addId(int $id): SetUsersForCostCenterRequest
    {
        $this->params->addId($id);

        return $this;
    }
}
