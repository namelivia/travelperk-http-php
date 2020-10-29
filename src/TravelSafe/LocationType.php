<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\TravelSafe;

use Namelivia\TravelPerk\BasicEnum;

class LocationType extends BasicEnum
{
    const COUNTRY = 'country_code';
    const IATA = 'iata_code';

    private $locationType;

    public function __construct(string $locationType)
    {
        parent::checkValidity($locationType);
        $this->locationType = $locationType;
    }

    public function __toString(): string
    {
        return $this->locationType;
    }
}
