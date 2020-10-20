<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Carbon\Carbon;
use Namelivia\TravelPerk\Expenses\BillingPeriod;
use Namelivia\TravelPerk\Expenses\InvoiceLinesInputParams;
use Namelivia\TravelPerk\Expenses\Status;

class InvoiceLinesInputParamTest extends TestCase
{
    public function testSettingInvoiceLinesAllInputParams()
    {
        $inputParams = new InvoiceLinesInputParams();
        $inputParams->setProfileId(['profile_id1', 'profile_id2'])
            ->setSerialNumber(['serial_number1', 'serial_number2'])
            ->setSerialContains('serial_number_contains')
            ->setBillingPeriod(BillingPeriod::MONTHLY)
            ->setTravelperkBankAccountNumber('bank_account_number')
            ->setCustomerCountryName('customer_country_name')
            ->setStatus(Status::PAID)
            ->setIssuingDateGte(Carbon::today())
            ->setIssuingDateLte(Carbon::tomorrow())
            ->setDueDateGte(Carbon::yesterday())
            ->setDueDateLte(Carbon::today()->endOfMonth())
            ->setExpenseDateGte(Carbon::today()->startOfMonth())
            ->setExpenseDateLte(Carbon::today()->startOfMonth())
            ->setOffset(32)
            ->setLimit(64);
        $this->assertEquals(
            'profile_id=profile_id1,profile_id2&'.
            'serial_number=serial_number1,serial_number2&'.
            'serial_number_contains=serial_number_contains&'.
            'billing_period=monthly&'.
            'travelperk_bank_account_number=bank_account_number&'.
            'customer_country_name=customer_country_name&'.
            'status=paid&'.
            'issuing_date_gte=2019-03-21&'.
            'issuing_date_lte=2019-03-22&'.
            'due_date_gte=2019-03-20&'.
            'due_date_lte=2019-03-31&'.
            'expense_date_gte=2019-03-01&'.
            'expense_date_lte=2019-03-01&'.
            'offset=32&'.
            'limit=64',
            urldecode($inputParams->asUrlParam())
        );
    }

    public function testSettingInvoiceLinesSomeInputParams()
    {
        $inputParams = new InvoiceLinesInputParams();
        $inputParams->setSerialNumber(['serial_number1', 'serial_number2'])
            ->setStatus(Status::PAID);
        $this->assertEquals(
            'serial_number=serial_number1,serial_number2&'.
            'status=paid',
            urldecode($inputParams->asUrlParam())
        );
    }

    public function testSettingInvoiceLinesNoInputParams()
    {
        $inputParams = new InvoiceLinesInputParams();
        $this->assertEquals('', urldecode($inputParams->asUrlParam()));
    }
}
