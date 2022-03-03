<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\GreenPerk;

class HotelEmissionsParams
{
    private $countryCode;
    private $numNights;

    public function __construct(string $countryCode, int $numNights)
    {
        $this->countryCode = $countryCode;
        $this->numNights = $numNights;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'country_code'                        => $this->countryCode,
            'num_nights'                         => $this->numNights,
        ]);
    }
}
