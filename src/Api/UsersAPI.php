<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Users\Users;

class UsersAPI
{
    private $users;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->users = new Users($travelPerk, $mapper);
    }

    public function users(): Users
    {
        return $this->users;
    }
}
