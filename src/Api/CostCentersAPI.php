<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\CostCenters\CostCenters;

class CostCentersAPI
{
    private $costCenters;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->costCenters = new CostCenters($travelPerk, $mapper);
    }

    public function costCenters(): CostCenters
    {
        return $this->costCenters;
    }
}
