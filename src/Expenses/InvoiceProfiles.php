<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Pagination\Pagination;
use JsonMapper\JsonMapper;

class InvoiceProfiles
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    /**
     * Query invoice profiles.
     */
    public function query(): InvoiceProfilesQuery
    {
        return new InvoiceProfilesQuery($this->travelPerk);
    }

    /**
     * List all invoice profiles associated to this account.
     */
    public function all(Pagination $pagination = null): object
    {
        $params = isset($pagination) ? '?'.$pagination->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['profiles']).$params);
    }
}
