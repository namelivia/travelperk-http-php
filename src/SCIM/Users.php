<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\UsersInputParams;
use Namelivia\TravelPerk\SCIM\CreateUserInputParams;

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
        return $this->travelPerk->getJson(implode('/', ['scim', 'Users']) . $params, true);
    }

    /**
     * Retrieve a user from TravelPerk.
     */
    public function get(int $id)
    {
        return $this->travelPerk->getJson(implode('/', ['scim', 'Users', $id]), true);
    }

    /**
     * Deletes a user from TravelPerk.
     */
    public function delete(int $id)
    {
        return $this->travelPerk->delete(implode('/', ['scim', 'Users', $id]), true);
    }

    /**
     * Create a new user in TravelPerk.
     */
    public function create(CreateUserInputParams $params)
    {
        return $this->travelPerk->post(implode('/', ['scim', 'Users', $id]), $params->asArray(), true);
    }
}
