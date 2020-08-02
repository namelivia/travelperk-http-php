<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Expenses\Sorting;
use Carbon\Carbon;

class InvoicesInputParams
{
    private $profileId;
    private $serialNumber;
    private $serialNumberContains;
    private $billingPeriod;
    private $accountNumber;
    private $customerCountryName;
    private $status;
    private $issuingDateGte;
    private $issuingDateLte;
    private $dueDateGte;
    private $dueDateLte;
    private $offset;
    private $limit;

    public function setProfileId(array $profileId)
    {
        $this->profileId = $profileId;
        return $this;
    }

    public function setSerialNumber(array $serialNumber)
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    public function setSerialContains(string $serialNumberContains)
    {
        $this->serialNumberContains = $serialNumberContains;
        return $this;
    }

    # TODO : This should be a constant
    public function setBillingPeriod(string $billingPeriod)
    {
        $this->billingPeriod = $billingPeriod;
        return $this;
    }

    public function setTravelperkBankAccountNumber(string $accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function setCustomerCountryName(string $customerCountryName)
    {
        $this->customerCountryName = $customerCountryName;
        return $this;
    }

    # TODO : This should be a constant
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    public function setIssuingDateGte(Carbon $issuingDateGte)
    {
        $this->issuingDateGte = $issuingDateGte;
        return $this;
    }

    public function setIssuingDateLte(Carbon $issuingDateLte)
    {
        $this->issuingDateLte = $issuingDateLte;
        return $this;
    }

    public function setDueDateGte(Carbon $dueDateGte)
    {
        $this->dueDateGte = $dueDateGte;
        return $this;
    }

    public function setDueDateLte(Carbon $dueDateLte)
    {
        $this->dueDateLte = $dueDateLte;
        return $this;
    }

    # TODO : In the documeantation there is an error on the type here
    public function setSort(Sorting $sort)
    {
        $this->sort = $sort;
        return $this;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function asUrlParam()
    {
        return http_build_query([
            'profile_id' => isset($this->profileId) ? implode(',', $this->profileId) : null,
            'serial_number' => isset($this->serialNumber) ? implode(',', $this->serialNumber) : null,
            'serial_number_contains' => $this->serialNumberContains,
            'billing_period' => $this->billingPeriod,
            'travelperk_bank_account_number' => $this->accountNumber,
            'customer_country_name' => $this->customerCountryName,
            'status' => $this->status,
            'issuing_date_gte' => isset($this->issuingDateGte) ? $this->issuingDateGte->format('Y-m-d') : null,
            'issuing_date_lte' => isset($this->issuingDateLte) ? $this->issuingDateLte->format('Y-m-d') : null,
            'due_date_gte' => isset($this->dueDateGte) ? $this->dueDateGte->format('Y-m-d') : null,
            'due_date_lte' => isset($this->dueDateLte) ? $this->dueDateLte->format('Y-m-d') : null,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'sort' => isset($this->sort) ? strval($this->sort) : null,
        ]);
    }
}
