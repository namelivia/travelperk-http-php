<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\GreenPerk;

class FlightEmissionsParams
{
    private $origin;
    private $destination;
    private $cabinClass;
    private $airlineCode;

    public function __construct(string $origin, string $destination, string $cabinClass, string $airlineCode)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->cabinClass = $cabinClass;
        $this->airlineCode = $airlineCode;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'origin'                        => $this->origin,
            'destination'                         => $this->destination,
            'cabin_class'                          => $this->cabinClass,
            'airline_code'                          => $this->airlineCode,
        ]);
    }
}
