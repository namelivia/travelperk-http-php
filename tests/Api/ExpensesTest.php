<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\JsonMapper;
use Mockery;
use Namelivia\TravelPerk\Api\Expenses;
use Namelivia\TravelPerk\Api\TravelPerk;

class ExpensesTest extends TestCase
{
    private $travelPerk;
    private $expenses;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->expenses = new Expenses($this->travelPerk, Mockery::mock(JsonMapper::class));
    }

    public function testGettingAnInvoiceProfilesInstance()
    {
        $this->assertTrue($this->expenses->invoiceProfiles() instanceof \Namelivia\TravelPerk\Expenses\InvoiceProfiles);
    }

    public function testGettingAnInvoicesInstance()
    {
        $this->assertTrue($this->expenses->invoices() instanceof \Namelivia\TravelPerk\Expenses\Invoices);
    }
}
