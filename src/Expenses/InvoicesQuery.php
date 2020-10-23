<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Carbon\Carbon;
use Namelivia\TravelPerk\Api\TravelPerk;

class InvoicesQuery
{
    private $params;
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->params = new InvoicesInputParams();
        $this->travelPerk = $travelPerk;
    }

    public function get(): object
    {
        return $this->travelPerk->getJson(
            implode('/', ['invoices']).'?'.$this->params->asUrlParam()
        );
    }

    public function setProfileId(array $profileId): InvoicesQuery
    {
        $this->params->setProfileId($profileId);

        return $this;
    }

    public function setSerialNumber(array $serialNumber): InvoicesQuery
    {
        $this->params->setSerialNumber($serialNumber);

        return $this;
    }

    public function setSerialContains(string $serialNumberContains): InvoicesQuery
    {
        $this->params->setSerialContains($serialNumberContains);

        return $this;
    }

    public function setBillingPeriod(string $billingPeriod): InvoicesQuery
    {
        $this->params->setBillingPeriod($billingPeriod);
    }

    public function setTravelperkBankAccountNumber(string $accountNumber): InvoicesQuery
    {
        $this->params->setTravelperkBankAccountNumber($accountNumber);

        return $this;
    }

    public function setCustomerCountryName(string $customerCountryName): InvoicesQuery
    {
        $this->params->setCustomerCountryName($customerCountryName);

        return $this;
    }

    public function setStatus(string $status): InvoicesQuery
    {
        $this->params->setStatus($status);

        return $this;
    }

    public function setIssuingDateGte(Carbon $issuingDateGte): InvoicesQuery
    {
        $this->params->setIssuingDateGte($issuingDateGte);

        return $this;
    }

    public function setIssuingDateLte(Carbon $issuingDateLte): InvoicesQuery
    {
        $this->params->setIssuingDateLte($issuingDateLte);

        return $this;
    }

    public function setDueDateGte(Carbon $dueDateGte): InvoicesQuery
    {
        $this->params->setDueDateGte($dueDateGte);

        return $this;
    }

    public function setDueDateLte(Carbon $dueDateLte): InvoicesQuery
    {
        $this->params->setDueDateLte($dueDateLte);

        return $this;
    }

    public function setSort(string $sort): InvoicesQuery
    {
        $this->params->setSort($sort);

        return $this;
    }

    public function setOffset(int $offset): InvoicesQuery
    {
        $this->params->setOffset($offset);

        return $this;
    }

    public function setLimit(int $limit): InvoicesQuery
    {
        $this->params->setLimit($limit);

        return $this;
    }
}
