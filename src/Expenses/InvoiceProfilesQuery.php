<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\Types\InvoiceProfilesPage;

class InvoiceProfilesQuery
{
    private $params;
    private $mapper;
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new InvoiceProfilesInputParams();
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

    public function setOffset(int $offset): InvoiceProfilesQuery
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit): InvoiceProfilesQuery
    {
        $this->params->setLimit($limit);

        return $this;
    }

    public function get(): InvoiceProfilesPage
    {
        return $this->execute(
            'get',
            implode('/', ['profiles']).'?'.$this->params->asUrlParam(),
            InvoiceProfilesPage::class
        );
    }
}
