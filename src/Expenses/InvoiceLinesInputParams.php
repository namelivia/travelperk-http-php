<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\Expenses\Status;
use Namelivia\TravelPerk\Expenses\BillingPeriod;
use Carbon\Carbon;

class InvoiceLinesInputParams
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
    private $expenseDateGte;
    private $expenseDateLte;
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

    public function setBillingPeriod(BillingPeriod $billingPeriod)
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

    public function setStatus(Status $status)
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

    public function setExpenseDateGte(Carbon $expenseDateGte)
    {
        $this->expenseDateGte = $expenseDateGte;
        return $this;
    }

    public function setExpenseDateLte(Carbon $expenseDateLte)
    {
        $this->expenseDateLte = $expenseDateLte;
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
            'billing_period' => isset($this->billingPeriod) ? strval($this->billingPeriod) : null,
            'travelperk_bank_account_number' => $this->accountNumber,
            'customer_country_name' => $this->customerCountryName,
            'status' => isset($this->status) ? strval($this->status) : null,
            'issuing_date_gte' => isset($this->issuingDateGte) ? $this->issuingDateGte->format('Y-m-d') : null,
            'issuing_date_lte' => isset($this->issuingDateLte) ? $this->issuingDateLte->format('Y-m-d') : null,
            'due_date_gte' => isset($this->dueDateGte) ? $this->dueDateGte->format('Y-m-d') : null,
            'due_date_lte' => isset($this->dueDateLte) ? $this->dueDateLte->format('Y-m-d') : null,
            'expense_date_gte' => isset($this->expenseDateGte) ? $this->expenseDateGte->format('Y-m-d') : null,
            'expense_date_lte' => isset($this->expenseDateLte) ? $this->expenseDateLte->format('Y-m-d') : null,
            'offset' => $this->offset,
            'limit' => $this->limit
        ]);
    }
}
