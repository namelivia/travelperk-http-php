<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

class SetUsersForCostCenterInputParams
{
    private $ids;

    public function __construct()
    {
        $this->ids = [];
    }

    public function addId(int $id): SetUsersForCostCenterInputParams
    {
        array_push($this->ids, $id);

        return $this;
    }

    public function asArray(): array
    {
        return array_filter([
            'user_ids' => $this->ids,
        ], function ($value) {return !is_null($value); });
    }
}
