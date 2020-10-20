<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;

class Invoices
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * List all invoices (Will be removed, use query instead).
     */
    public function all(InvoicesInputParams $params = null)
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['invoices']).$params);
    }

    /**
     * Query invoices.
     */
    public function query()
    {
        return new InvoicesQuery($this->travelPerk);
    }

    /**
     * Get invoice detail.
     */
    public function get(string $serialNumber)
    {
        return $this->travelPerk->getJson(implode('/', ['invoices', $serialNumber]));
    }

    /**
     * Get invoice in PDF format.
     */
    public function pdf(string $serialNumber)
    {
        return $this->travelPerk->get(implode('/', ['invoices', $serialNumber, 'pdf']));
    }

    /**
     * Get list of invoices lines.
     */
    public function lines(InvoiceLinesInputParams $params = null)
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['invoices', 'lines']).$params);
    }

    /**
     * Query the invoices lines.
     */
    public function linesQuery()
    {
        return new InvoiceLinesQuery($this->travelPerk);
    }

    /**
     * Get all billing periods
     */
    public function billingPeriods()
    {
        return BillingPeriod::getConstantValues();
    }

    /**
     * Get all statuses
     */
    public function statuses()
    {
        return Status::getConstantValues();
    }

    /**
     * Get all sorting values
     */
    public function sorting()
    {
        return Sorting::getConstantValues();
    }
}
