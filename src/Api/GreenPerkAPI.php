<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\GreenPerk\GreenPerk;

class GreenPerkAPI
{
    private $greenPerk;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->greenPerk = new GreenPerk($travelPerk, $mapper);
    }

    public function greenPerk(): GreenPerk
    {
        return $this->greenPerk;
    }
}
