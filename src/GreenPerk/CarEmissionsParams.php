<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\GreenPerk;

class CarEmissionsParams
{
    private $acrissCode;
    private $numDays;
    private $distancePerDay;

    public function __construct(string $acrissCode, int $numDays, int $distancePerDay = null)
    {
        $this->acrissCode = $acrissCode;
        $this->numDays = $numDays;
        $this->distancePerDay = $distancePerDay;
    }

    public function asUrlParam(): string
    {
        return http_build_query(array_filter([
            'acriss_code'                               => $this->acrissCode,
            'num_days'                                  => $this->numDays,
            'distance_per_day'                          => $this->distancePerDay ? $this->distancePerDay : null,
        ]));
    }
}
