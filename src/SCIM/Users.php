<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Exceptions\NotImplementedException;

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
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['scim', 'Users']).$params);
    }

    /**
     * Retrieve a user from TravelPerk.
     */
    public function get(int $id)
    {
        return $this->travelPerk->getJson(implode('/', ['scim', 'Users', $id]));
    }

    /**
     * Deletes a user from TravelPerk.
     */
    public function delete(int $id)
    {
        return $this->travelPerk->delete(implode('/', ['scim', 'Users', $id]));
    }

    /**
     * Create a new user in TravelPerk.
     */
    public function create(CreateUserInputParams $params)
    {
        return $this->travelPerk->postJson(implode('/', ['scim', 'Users']), $params->asArray());
    }

    /**
     * Update an existing user in TravelPerk.
     */
    public function update(int $id, UpdateUserInputParams $params)
    {
        throw new NotImplementedException('https://github.com/namelivia/travelperk-http-php/issues/7');

        return $this->travelPerk->patch(implode('/', ['scim', 'Users', $id]), $params->asArray());
    }

    /**
     * Replace an existing user in TravelPerk.
     */
    public function replace(int $id, ReplaceUserInputParams $params)
    {
        return $this->travelPerk->putJson(implode('/', ['scim', 'Users', $id]), $params->asArray());
    }
}
