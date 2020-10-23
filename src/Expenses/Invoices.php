<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\Types\Invoice;
use JsonMapper\JsonMapper;

class Invoices
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, array $url, string $class)
    {
        $result = new $class;
        $response = $this->travelPerk->{$method}(implode('/', $url));
        $this->mapper->mapObject(
            json_decode($response),
            $result
        );
        return $result;
    }

    /**
     * List all invoices (Will be removed, use query instead).
     */
    public function all(InvoicesInputParams $params = null): object
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['invoices']).$params);
    }

    /**
     * Query invoices.
     */
    public function query(): InvoicesQuery
    {
        return new InvoicesQuery($this->travelPerk);
    }

    /**
     * Get invoice detail.
     */
    public function get(string $serialNumber): Invoice
    {
        return $this->execute('get', ['invoices', $serialNumber], Invoice::class);
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
    public function lines(InvoiceLinesInputParams $params = null): object
    {
        $params = isset($params) ? '?'.$params->asUrlParam() : null;

        return $this->travelPerk->getJson(implode('/', ['invoices', 'lines']).$params);
    }

    /**
     * Query the invoices lines.
     */
    public function linesQuery(): InvoiceLinesQuery
    {
        return new InvoiceLinesQuery($this->travelPerk);
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
