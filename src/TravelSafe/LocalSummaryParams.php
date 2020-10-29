<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\TravelSafe;

class LocalSummaryParams
{
    private $location;
    private $locationType;

    public function __construct(
        string $location,
        string $locationType
    ) {
        $this->setLocation($location);
        $this->setLocationType($locationType);
    }

    public function setLocation(string $location): LocalSummaryParams
    {
        $this->location = $location;

        return $this;
    }

    public function setLocationType(string $locationType): LocalSummaryParams
    {
        $this->locationType = new LocationType($locationType);

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'location_type' => strval($this->locationType),
            'location'      => $this->location,
        ]);
    }
}
