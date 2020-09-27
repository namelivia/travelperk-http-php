<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Pagination\Pagination;

class InvoiceProfiles
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * Query invoice profiles
     */
    public function query()
    {
        return new InvoiceProfilesQuery($this->travelPerk);
    }

    /**
     * List all invoice profiles associated to this account.
     */
    public function all(Pagination $pagination = null)
    {
        $params = isset($pagination) ? '?'.$pagination->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['profiles']).$params);
    }
}
