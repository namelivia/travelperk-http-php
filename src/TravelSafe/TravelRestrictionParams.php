<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\TravelSafe;

use Carbon\Carbon;

class TravelRestrictionParams
{
    private $origin;
    private $destination;
    private $originType;
    private $destinationType;
    private $date;

    public function __construct(
        string $origin,
        string $destination,
        string $originType,
        string $destinationType,
        Carbon $date
    ) {
        $this->setOrigin($origin);
        $this->setDestination($destination);
        $this->setOriginType($originType);
        $this->setDestinationType($destinationType);
        $this->setDate($date);
    }

    public function setOrigin(string $origin): TravelRestrictionParams
    {
        $this->origin = $origin;

        return $this;
    }

    public function setDestination(string $destination): TravelRestrictionParams
    {
        $this->destination = $destination;

        return $this;
    }

    public function setOriginType(string $originType): TravelRestrictionParams
    {
        $this->originType = new LocationType($originType);

        return $this;
    }

    public function setDestinationType(string $destinationType): TravelRestrictionParams
    {
        $this->destinationType = new LocationType($destinationType);

        return $this;
    }

    public function setDate(Carbon $date): TravelRestrictionParams
    {
        $this->date = $date;

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'origin'           => $this->origin,
            'destination'      => $this->destination,
            'origin_type'      => strval($this->originType),
            'destination_type' => strval($this->destinationType),
            'date'             => $this->date->format('Y-m-d'),
        ]);
    }
}
