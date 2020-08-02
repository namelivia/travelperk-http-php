<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Expenses\InvoiceProfiles;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Pagination\Pagination;

class InvoiceProfilesTest extends TestCase
{
    private $travelPerk;
    private $invoiceProfiles;

    public function setUp():void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->invoiceProfiles = new InvoiceProfiles($this->travelPerk);
    }

    public function testGettingAllInvoiceProfilesNoPagination()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('profiles')
            ->andReturn('allInvoiceProfiles');
        $this->assertEquals(
            'allInvoiceProfiles',
            $this->invoiceProfiles->all()
        );
    }

    public function testGettingAllInvoiceProfilesWithPagination()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('profiles?offset=20&limit=30')
            ->andReturn('allInvoiceProfiles');
        $this->assertEquals(
            'allInvoiceProfiles',
            $this->invoiceProfiles->all(new Pagination(20, 30))
        );
    }
}
