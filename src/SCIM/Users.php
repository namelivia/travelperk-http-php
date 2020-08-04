<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;

class Users
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * List all users associated to this account.
     */
    public function all()
    {
        return $this->travelPerk->getJsonLegacy(implode('/', ['scim', 'Users']));
    }

}
