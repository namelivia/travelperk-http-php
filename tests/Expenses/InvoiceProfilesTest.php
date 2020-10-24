<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\InvoiceProfiles;
use Namelivia\TravelPerk\Pagination\Pagination;

class InvoiceProfilesTest extends TestCase
{
    private $travelPerk;
    private $invoiceProfiles;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->invoiceProfiles = new InvoiceProfiles($this->travelPerk, $this->mapper);
    }

    private function assertEqualsStub($invoiceProfilesPage): void
    {
        $this->assertEquals(0, $invoiceProfilesPage->offset);
        $this->assertEquals(10, $invoiceProfilesPage->limit);
        $this->assertEquals(2, $invoiceProfilesPage->total);
        $this->assertEquals(2, count($invoiceProfilesPage->profiles));
        $this->assertEquals('f2dd1aa3-5601-4725-a520-bd59885bbb16', $invoiceProfilesPage->profiles[0]->id);
        $this->assertEquals('My Company Ltd', $invoiceProfilesPage->profiles[0]->name);
        $this->assertEquals('automatic', $invoiceProfilesPage->profiles[0]->paymentMethodType);
        $this->assertEquals('instant', $invoiceProfilesPage->profiles[0]->billingPeriod);
        $this->assertEquals('GBP', $invoiceProfilesPage->profiles[0]->currency);
        $this->assertEquals('My Company Ltd', $invoiceProfilesPage->profiles[0]->billingInformation->legalName);
        $this->assertEquals('GB123456789', $invoiceProfilesPage->profiles[0]->billingInformation->vatNumber);
        $this->assertEquals('199 Bishopsgate', $invoiceProfilesPage->profiles[0]->billingInformation->addressLine1);
        $this->assertEquals('Spitalfields', $invoiceProfilesPage->profiles[0]->billingInformation->addressLine2);
        $this->assertEquals('London', $invoiceProfilesPage->profiles[0]->billingInformation->city);
        $this->assertEquals('EC2M 3TY', $invoiceProfilesPage->profiles[0]->billingInformation->postalCode);
        $this->assertEquals('United Kingdom', $invoiceProfilesPage->profiles[0]->billingInformation->countryName);
        $this->assertEquals('8fa66535-5a9a-4a6f-90d8-2986621a706a', $invoiceProfilesPage->profiles[1]->id);
        $this->assertEquals('My Spanish Company SL', $invoiceProfilesPage->profiles[1]->name);
        $this->assertEquals('manual', $invoiceProfilesPage->profiles[1]->paymentMethodType);
        $this->assertEquals('monthly', $invoiceProfilesPage->profiles[1]->billingPeriod);
        $this->assertEquals('EUR', $invoiceProfilesPage->profiles[1]->currency);
        $this->assertEquals('My Spanish Company SL', $invoiceProfilesPage->profiles[1]->billingInformation->legalName);
        $this->assertEquals('ES123456789', $invoiceProfilesPage->profiles[1]->billingInformation->vatNumber);
        $this->assertEquals('Passeig de Gracia 345', $invoiceProfilesPage->profiles[1]->billingInformation->addressLine1);
        $this->assertEquals('Planta 14', $invoiceProfilesPage->profiles[1]->billingInformation->addressLine2);
        $this->assertEquals('Barcelona', $invoiceProfilesPage->profiles[1]->billingInformation->city);
        $this->assertEquals('080123', $invoiceProfilesPage->profiles[1]->billingInformation->postalCode);
        $this->assertEquals('Spain', $invoiceProfilesPage->profiles[1]->billingInformation->countryName);
    }

    public function testGettingAllInvoiceProfilesNoPagination()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('profiles')
            ->andReturn(file_get_contents('tests/stubs/invoiceProfiles.json'));
        $invoiceProfilesPage = $this->invoiceProfiles->all();
        $this->assertEqualsStub($invoiceProfilesPage);
    }

    public function testGettingAllInvoiceProfilesWithPagination()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('profiles?offset=20&limit=30')
            ->andReturn(file_get_contents('tests/stubs/invoiceProfiles.json'));
        $invoiceProfilesPage = $this->invoiceProfiles->all(new Pagination(20, 30));
        $this->assertEqualsStub($invoiceProfilesPage);
    }

    public function testGettingAllInvoiceProfilesWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('profiles?offset=30&limit=20')
            ->andReturn(file_get_contents('tests/stubs/invoiceProfiles.json'));
        $invoiceProfilesPage = $this->invoiceProfiles->query()->setLimit(20)->setOffset(30)->get();
        $this->assertEqualsStub($invoiceProfilesPage);
    }
}
