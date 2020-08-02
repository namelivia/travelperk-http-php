<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Expenses\InvoicesInputParams;
use Namelivia\TravelPerk\Expenses\Sorting;
use Carbon\Carbon;

class InvoicesInputParamTest extends TestCase
{
    public function testSettingInvoicesAllInputParams()
    {
        $inputParams = new InvoicesInputParams();
        $inputParams->setProfileId(['profile_id1', 'profile_id2'])
            ->setSerialNumber(['serial_number1', 'serial_number2'])
            ->setSerialContains('serial_number_contains')
            ->setBillingPeriod('billing_period')
            ->setTravelperkBankAccountNumber('bank_account_number')
            ->setCustomerCountryName('customer_country_name')
            ->setStatus('status')
            ->setIssuingDateGte(Carbon::today())
            ->setIssuingDateLte(Carbon::tomorrow())
            ->setDueDateGte(Carbon::yesterday())
            ->setDueDateLte(Carbon::today()->endOfMonth())
            ->setOffset(32)
            ->setLimit(64)
            ->setSort(new Sorting(Sorting::ISSUING_DATE_ASC));
        $this->assertEquals(
            'profile_id=profile_id1,profile_id2&' .
            'serial_number=serial_number1,serial_number2&' .
            'serial_number_contains=serial_number_contains&' .
            'billing_period=billing_period&' .
            'travelperk_bank_account_number=bank_account_number&' .
            'customer_country_name=customer_country_name&' .
            'status=status&' .
            'issuing_date_gte=2019-03-21&' .
            'issuing_date_lte=2019-03-22&' .
            'due_date_gte=2019-03-20&' .
            'due_date_lte=2019-03-31&' .
            'offset=32&' .
            'limit=64&' .
            'sort=issuing_date',
            urldecode($inputParams->asUrlParam())
        );
    }

    public function testSettingInvoicesSomeInputParams()
    {
        $inputParams = new InvoicesInputParams();
        $inputParams->setSerialNumber(['serial_number1', 'serial_number2'])
            ->setStatus('status');
        $this->assertEquals(
            'serial_number=serial_number1,serial_number2&' .
            'status=status',
            urldecode($inputParams->asUrlParam())
        );
    }

    public function testSettingInvoicesNoInputParams()
    {
        $inputParams = new InvoicesInputParams();
        $this->assertEquals('', urldecode($inputParams->asUrlParam()));
    }
}
