<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\SCIM\Discovery;
use Namelivia\TravelPerk\SCIM\Users;

class SCIM
{
    private $discovery;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->discovery = new Discovery($travelPerk);
        $this->users = new Users($travelPerk, $mapper);
    }

    public function discovery(): Discovery
    {
        return $this->discovery;
    }

    public function users(): Users
    {
        return $this->users;
    }
}
