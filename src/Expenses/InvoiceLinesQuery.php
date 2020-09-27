<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Api\TravelPerk;

class InvoiceLinesQuery
{
    private $params;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->params = new InvoiceLinesInputParams();
        $this->travelPerk = $travelPerk;
    }

    public function get()
    {
        return $this->travelPerk->getJson(
            implode('/', ['invoices', 'lines']).'?'.$this->params->asUrlParam()
        );
    }

    public function setProfileId(array $profileId)
    {
        $this->params->setProfileId($profileId);

        return $this;
    }

    public function setSerialNumber(array $serialNumber)
    {
        $this->params->setSerialNumber($serialNumber);

        return $this;
    }

    public function setSerialContains(string $serialNumberContains)
    {
        $this->params->setSerialNumberContains($serialNumberContains);

        return $this;
    }

    public function setBillingPeriod(BillingPeriod $billingPeriod)
    {
        $this->params->setBillingPeriod($billingPeriod);

        return $this;
    }

    public function setTravelperkBankAccountNumber(string $accountNumber)
    {
        $this->params->setAccountNumber($accountNumber);

        return $this;
    }

    public function setCustomerCountryName(string $customerCountryName)
    {
        $this->params->setCustomerCountryName($customerCountryName);

        return $this;
    }

    public function setStatus(Status $status)
    {
        $this->params->setStatus($status);

        return $this;
    }

    public function setIssuingDateGte(Carbon $issuingDateGte)
    {
        $this->params->setIssuingDateGte($issuingDateGte);

        return $this;
    }

    public function setIssuingDateLte(Carbon $issuingDateLte)
    {
        $this->params->setIssuingDateLte($issuingDateLte);

        return $this;
    }

    public function setDueDateGte(Carbon $dueDateGte)
    {
        $this->params->setDueDateGte($dueDateGte);

        return $this;
    }

    public function setDueDateLte(Carbon $dueDateLte)
    {
        $this->params->setDueDateLte($dueDateLte);

        return $this;
    }

    public function setExpenseDateGte(Carbon $expenseDateGte)
    {
        $this->params->setExpenseDateGte($expenseDateGte);

        return $this;
    }

    public function setExpenseDateLte(Carbon $expenseDateLte)
    {
        $this->params->setExpenseDateLte($expenseDateLte);

        return $this;
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

}
