<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\CostCenters;

class BulkUpdateCostCenterInputParams
{
    private $ids;
    private $archive;

    public function setIds(array $ids): BulkUpdateCostCenterInputParams
    {
        $this->ids = $ids;

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
