<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

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
    private $sort;

    public function setProfileId(array $profileId): InvoicesInputParams
    {
        $this->profileId = $profileId;

        return $this;
    }

    public function setSerialNumber(array $serialNumber): InvoicesInputParams
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function setSerialContains(string $serialNumberContains): InvoicesInputParams
    {
        $this->serialNumberContains = $serialNumberContains;

        return $this;
    }

    public function setBillingPeriod(string $billingPeriod): InvoicesInputParams
    {
        $this->billingPeriod = new BillingPeriod($billingPeriod);

        return $this;
    }

    public function setTravelperkBankAccountNumber(string $accountNumber): InvoicesInputParams
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function setCustomerCountryName(string $customerCountryName): InvoicesInputParams
    {
        $this->customerCountryName = $customerCountryName;

        return $this;
    }

    public function setStatus(string $status): InvoicesInputParams
    {
        $this->status = new Status($status);

        return $this;
    }

    public function setIssuingDateGte(Carbon $issuingDateGte): InvoicesInputParams
    {
        $this->issuingDateGte = $issuingDateGte;

        return $this;
    }

    public function setIssuingDateLte(Carbon $issuingDateLte): InvoicesInputParams
    {
        $this->issuingDateLte = $issuingDateLte;

        return $this;
    }

    public function setDueDateGte(Carbon $dueDateGte): InvoicesInputParams
    {
        $this->dueDateGte = $dueDateGte;

        return $this;
    }

    public function setDueDateLte(Carbon $dueDateLte): InvoicesInputParams
    {
        $this->dueDateLte = $dueDateLte;

        return $this;
    }

    public function setSort(string $sort): InvoicesInputParams
    {
        $this->sort = new Sorting($sort);

        return $this;
    }

    public function setOffset(int $offset): InvoicesInputParams
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): InvoicesInputParams
    {
        $this->limit = $limit;

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'profile_id'                     => isset($this->profileId) ? implode(',', $this->profileId) : null,
            'serial_number'                  => isset($this->serialNumber) ? implode(',', $this->serialNumber) : null,
            'serial_number_contains'         => $this->serialNumberContains,
            'billing_period'                 => isset($this->billingPeriod) ? strval($this->billingPeriod) : null,
            'travelperk_bank_account_number' => $this->accountNumber,
            'customer_country_name'          => $this->customerCountryName,
            'status'                         => isset($this->status) ? strval($this->status) : null,
            'issuing_date_gte'               => isset($this->issuingDateGte) ? $this->issuingDateGte->format('Y-m-d') : null,
            'issuing_date_lte'               => isset($this->issuingDateLte) ? $this->issuingDateLte->format('Y-m-d') : null,
            'due_date_gte'                   => isset($this->dueDateGte) ? $this->dueDateGte->format('Y-m-d') : null,
            'due_date_lte'                   => isset($this->dueDateLte) ? $this->dueDateLte->format('Y-m-d') : null,
            'offset'                         => $this->offset,
            'limit'                          => $this->limit,
            'sort'                           => isset($this->sort) ? strval($this->sort) : null,
        ]);
    }
}
