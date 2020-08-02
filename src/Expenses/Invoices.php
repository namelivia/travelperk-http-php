<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\InvoicesInputParams;

class Invoices
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * Get list of invoices
     */
    public function all(InvoicesInputParams $params = null)
    {
        $params = isset($params) ? '?' . $params->asUrlParam() : null;
        return $this->travelPerk->getJson(implode('/', ['invoices']) .  $params);
    }

    /**
     * Get invoice detail
     */
    public function get(string $serialNumber)
    {
        return $this->travelPerk->getJson(implode('/', ['invoices', $serialNumber]));
    }

    /**
     * Get invoice in PDF format
     */
    public function pdf(string $serialNumber)
    {
        return $this->travelPerk->get(implode('/', ['invoices', $serialNumber, 'pdf']));
    }

    /**
     * Get list of invoices lines
     */
    #TODO: This endpoint accepts a LOT more params
    public function lines()
    {
        return $this->travelPerk->getJson(implode('/', ['invoices', 'lines']));
    }
}
