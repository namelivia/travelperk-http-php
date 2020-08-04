<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\UsersInputParams;

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
    public function all(UsersInputParams $params = null)
    {
        $params = isset($params) ? '?' . $params->asUrlParam() : null;
        return $this->travelPerk->getJsonLegacy(implode('/', ['scim', 'Users']) . $params);
    }

    /**
     * Retrieve a user from TravelPerk.
     */
    public function get(int $id)
    {
        return $this->travelPerk->getJsonLegacy(implode('/', ['scim', 'Users', $id]));
    }

}
