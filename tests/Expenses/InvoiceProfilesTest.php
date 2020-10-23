<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\InvoiceProfiles;
use Namelivia\TravelPerk\Pagination\Pagination;
use JsonMapper\JsonMapper;

class InvoiceProfilesTest extends TestCase
{
    private $travelPerk;
    private $invoiceProfiles;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->invoiceProfiles = new InvoiceProfiles($this->travelPerk, Mockery::mock(JsonMapper::class));
    }

    public function testGettingAllInvoiceProfilesNoPagination()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('profiles')
            ->andReturn((object) ['data' => 'allInvoiceProfiles']);
        $this->assertEquals(
            (object) ['data' => 'allInvoiceProfiles'],
            $this->invoiceProfiles->all()
        );
    }

    public function testGettingAllInvoiceProfilesWithPagination()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('profiles?offset=20&limit=30')
            ->andReturn((object) ['data' => 'allInvoiceProfiles']);
        $this->assertEquals(
            (object) ['data' => 'allInvoiceProfiles'],
            $this->invoiceProfiles->all(new Pagination(20, 30))
        );
    }

    public function testGettingAllInvoiceProfilesWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('profiles?offset=30&limit=20')
            ->andReturn((object) ['data' => 'allInvoiceProfiles']);
        $this->assertEquals(
            (object) ['data' => 'allInvoiceProfiles'],
            $this->invoiceProfiles->query()->setLimit(20)->setOffset(30)->get()
        );
    }
}
