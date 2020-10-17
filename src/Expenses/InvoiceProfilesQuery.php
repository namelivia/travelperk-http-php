<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;

class InvoiceProfilesQuery
{
    private $params;
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->params = new InvoiceProfilesInputParams();
        $this->travelPerk = $travelPerk;
    }

    public function setOffset(int $offset)
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit)
    {
        $this->params->setLimit($limit);

        return $this;
    }

    public function get()
    {
        return $this->travelPerk->getJson(
            implode('/', ['profiles']).'?'.$this->params->asUrlParam()
        );
    }
}
