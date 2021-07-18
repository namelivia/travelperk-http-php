<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

class CreateCostCenterInputParams
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setName(string $name): CreateCostCenterInputParams
    {
        $this->name = $name;

        return $this;
    }

    public function asArray(): array
    {
        $data = array_filter([
            'name'              => $this->name,
        ]);

        return $data;
    }
}
