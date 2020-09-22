<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;

class InvoicesQuery
{
    private $params;

    public function __construct(TravelPerk $travelPerk) {
        $this->params = new InvoicesInputParams;
        $this->travelPerk = $travelPerk;
    }

    public function get() {
        return $this->travelPerk->getJson(implode('/', ['invoices']).$this->params);
    }

    public function setProfileId(array $profileId)
    {
        $this->params->setProfileId($profileId);
    }

    public function setSerialNumber(array $serialNumber)
    {
        $this->params->setSerialNumber($serialNumber);
    }

    public function setSerialContains(string $serialNumberContains)
    {
        $this->params->setSerialContains($serialNumberContains);
    }

    public function setBillingPeriod(BillingPeriod $billingPeriod)
    {
        $this->params->setBillingPeriod($billingPeriod);
    }

    public function setTravelperkBankAccountNumber(string $accountNumber)
    {
        $this->params->setTravelperkBankAccountNumber($accountNumber);
    }

    public function setCustomerCountryName(string $customerCountryName)
    {
        $this->params->setCustomerCountryName($customerCountryName);
    }

    public function setStatus(Status $status)
    {
        $this->params->setStatus($status);
    }

    public function setIssuingDateGte(Carbon $issuingDateGte)
    {
        $this->params->setIssuingDateGte($issuingDateGte);
    }

    public function setIssuingDateLte(Carbon $issuingDateLte)
    {
        $this->params->setIssuingDateLte($issuingDateLte);
    }

    public function setDueDateGte(Carbon $dueDateGte)
    {
        $this->params->setDueDateGte($dueDateGte);
    }

    public function setDueDateLte(Carbon $dueDateLte)
    {
        $this->params->setDueDateLte($dueDateLte);
    }

    public function setSort(Sorting $sort)
    {
        $this->params->setSort($sort);
    }

    public function setOffset(int $offset)
    {
        $this->params->setOffset($offset);
    }

    public function setLimit(int $limit)
    {
        $this->params->setLimit($limit);
    }
}
