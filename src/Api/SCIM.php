<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use Namelivia\TravelPerk\SCIM\Discovery;

class SCIM
{
    private $discovery;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->discovery  = new Discovery($travelPerk);
    }

    public function discovery()
    {
        return $this->discovery;
    }
}
