<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;

class Discovery
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * Returns TravelPerk's configuration details for our SCIM API,
     * including which operations are supported.
     */
    public function serviceProviderConfig()
    {
        return $this->travelPerk->getJsonLegacy(implode('/', ['scim', 'ServiceProviderConfig']));
    }
}
