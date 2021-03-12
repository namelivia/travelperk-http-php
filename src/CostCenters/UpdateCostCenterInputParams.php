<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

class UpdateCostCenterInputParams
{
    private $name;
    private $archive;

    public function setName(string $name): UpdateCostCenterInputParams
    {
        $this->name = $name;

        return $this;
    }

    public function setArchive(bool $archive): UpdateCostCenterInputParams
    {
        $this->archive = $archive;

        return $this;
    }

    public function asArray(): array
    {
        return array_filter([
            'name'    => $this->name,
            'archive' => $this->archive,
        ], function ($value) {return !is_null($value); });
    }
}
