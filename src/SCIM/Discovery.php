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
    public function serviceProviderConfig(): object
    {
        return json_decode($this->travelPerk->get(implode('/', ['scim', 'ServiceProviderConfig'])));
    }

    /**
     * Returns all available resources types for our SCIM API.
     */
    public function resourceTypes(): object
    {
        return json_decode($this->travelPerk->get(implode('/', ['scim', 'ResourceTypes'])));
    }

    /**
     * List all schemas and their attributes.
     */
    public function schemas(): object
    {
        return json_decode($this->travelPerk->get(implode('/', ['scim', 'Schemas'])));
    }

    /**
     * List all attributes for the User schema.
     */
    public function userSchema(): object
    {
        return json_decode($this->travelPerk->get(implode('/', ['scim', 'Schemas', 'urn:ietf:params:scim:schemas:core:2.0:User'])));
    }

    /**
     * List all attributes for the Enterprise User schema.
     */
    public function enterpriseUserSchema(): object
    {
        return json_decode(
            $this->travelPerk->get(implode('/', ['scim', 'Schemas', 'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User']))
        );
    }
}
