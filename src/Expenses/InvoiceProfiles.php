<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\InvoiceProfiles\InvoiceProfiles as InvoiceProfilesType;
use Namelivia\TravelPerk\Pagination\Pagination;

class InvoiceProfiles
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class)
    {
        $result = new $class();
        $response = $this->travelPerk->{$method}($url);
        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    /**
     * Query invoice profiles.
     */
    public function query(): InvoiceProfilesQuery
    {
        return new InvoiceProfilesQuery($this->travelPerk, $this->mapper);
    }

    /**
     * List all invoice profiles associated to this account.
     */
    public function all(Pagination $pagination = null): InvoiceProfilesType
    {
        $params = isset($pagination) ? '?'.$pagination->asUrlParam() : null;

        return $this->execute('get', implode('/', ['profiles']).$params, InvoiceProfilesType::class);
    }
}
