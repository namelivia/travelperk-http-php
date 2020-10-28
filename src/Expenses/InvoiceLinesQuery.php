<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Carbon\Carbon;
use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\InvoiceLines\InvoiceLines as InvoiceLinesType;

class InvoiceLinesQuery
{
    private $params;
    private $mapper;
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->params = new InvoiceLinesInputParams();
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

    public function get(): InvoiceLinesType
    {
        return $this->execute(
            'get',
            implode('/', ['invoices', 'lines']).'?'.$this->params->asUrlParam(),
            InvoiceLinesType::class
        );
    }

    public function setProfileId(array $profileId): InvoiceLinesQuery
    {
        $this->params->setProfileId($profileId);

        return $this;
    }

    public function setSerialNumber(array $serialNumber): InvoiceLinesQuery
    {
        $this->params->setSerialNumber($serialNumber);

        return $this;
    }

    public function setSerialContains(string $serialNumberContains): InvoiceLinesQuery
    {
        $this->params->setSerialContains($serialNumberContains);

        return $this;
    }

    public function setBillingPeriod(string $billingPeriod): InvoiceLinesQuery
    {
        $this->params->setBillingPeriod($billingPeriod);

        return $this;
    }

    public function setTravelperkBankAccountNumber(string $accountNumber): InvoiceLinesQuery
    {
        $this->params->setTravelperkBankAccountNumber($accountNumber);

        return $this;
    }

    public function setCustomerCountryName(string $customerCountryName): InvoiceLinesQuery
    {
        $this->params->setCustomerCountryName($customerCountryName);

        return $this;
    }

    public function setStatus(string $status): InvoiceLinesQuery
    {
        $this->params->setStatus($status);

        return $this;
    }

    public function setIssuingDateGte(Carbon $issuingDateGte): InvoiceLinesQuery
    {
        $this->params->setIssuingDateGte($issuingDateGte);

        return $this;
    }

    public function setIssuingDateLte(Carbon $issuingDateLte): InvoiceLinesQuery
    {
        $this->params->setIssuingDateLte($issuingDateLte);

        return $this;
    }

    public function setDueDateGte(Carbon $dueDateGte): InvoiceLinesQuery
    {
        $this->params->setDueDateGte($dueDateGte);

        return $this;
    }

    public function setDueDateLte(Carbon $dueDateLte): InvoiceLinesQuery
    {
        $this->params->setDueDateLte($dueDateLte);

        return $this;
    }

    public function setExpenseDateGte(Carbon $expenseDateGte): InvoiceLinesQuery
    {
        $this->params->setExpenseDateGte($expenseDateGte);

        return $this;
    }

    public function setExpenseDateLte(Carbon $expenseDateLte): InvoiceLinesQuery
    {
        $this->params->setExpenseDateLte($expenseDateLte);

        return $this;
    }

    public function setOffset(int $offset): InvoiceLinesQuery
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit): InvoiceLinesQuery
    {
        $this->params->setLimit($limit);

        return $this;
    }
}
