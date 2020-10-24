<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\Types\Invoice;
use Namelivia\TravelPerk\Expenses\Types\InvoiceLinesPage;
use Namelivia\TravelPerk\Expenses\Types\InvoicesPage;

class Invoices
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
     * List all invoices (Will be removed, use query instead).
     */
    public function all(InvoicesInputParams $params = null): InvoicesPage
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->execute('get', implode('/', ['invoices']).$params, InvoicesPage::class);
    }

    /**
     * Query invoices.
     */
    public function query(): InvoicesQuery
    {
        return new InvoicesQuery($this->travelPerk, $this->mapper);
    }

    /**
     * Get invoice detail.
     */
    public function get(string $serialNumber): Invoice
    {
        return $this->execute('get', implode('/', ['invoices', $serialNumber]), Invoice::class);
    }

    /**
     * Get invoice in PDF format.
     */
    public function pdf(string $serialNumber): string
    {
        return $this->travelPerk->get(implode('/', ['invoices', $serialNumber, 'pdf']));
    }

    /**
     * Get list of invoices lines.
     */
    public function lines(InvoiceLinesInputParams $params = null): InvoiceLinesPage
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->execute('get', implode('/', ['invoices', 'lines']).$params, InvoiceLinesPage::class);
    }

    /**
     * Query the invoices lines.
     */
    public function linesQuery(): InvoiceLinesQuery
    {
        return new InvoiceLinesQuery($this->travelPerk, $this->mapper);
    }

    /**
     * Get all billing periods.
     */
    public function billingPeriods(): array
    {
        return BillingPeriod::getConstantValues();
    }

    /**
     * Get all statuses.
     */
    public function statuses(): array
    {
        return Status::getConstantValues();
    }

    /**
     * Get all sorting values.
     */
    public function sorting(): array
    {
        return Sorting::getConstantValues();
    }
}
