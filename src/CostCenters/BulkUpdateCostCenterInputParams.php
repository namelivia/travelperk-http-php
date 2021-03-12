<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

class BulkUpdateCostCenterInputParams
{
    private $ids;
    private $archive;

    public function __construct()
    {
        $this->ids = [];
    }

    public function addId(int $id): BulkUpdateCostCenterInputParams
    {
        array_push($this->ids, $id);

        return $this;
    }

    public function setArchive(bool $archive): BulkUpdateCostCenterInputParams
    {
        $this->archive = $archive;

        return $this;
    }

    public function asArray(): array
    {
        return array_filter([
            'id_list' => $this->ids,
            'archive' => $this->archive,
        ], function ($value) {return !is_null($value); });
    }
}
