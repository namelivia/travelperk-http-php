<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\TravelSafe\TravelSafe;

class TravelSafeAPI
{
    private $travelSafe;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelSafe = new TravelSafe($travelPerk, $mapper);
    }

    public function travelSafe(): TravelSafe
    {
        return $this->travelSafe;
    }
}
