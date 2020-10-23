<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Expenses\InvoiceLinesInputParams;
use Namelivia\TravelPerk\Expenses\Invoices;
use Namelivia\TravelPerk\Expenses\InvoicesInputParams;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use JsonMapper\Enums\TextNotation;

class InvoicesTest extends TestCase
{
    private $travelPerk;
    private $invoices;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->invoices = new Invoices($this->travelPerk, $this->mapper);
    }

    public function testGettingAllInvoicesNoParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('invoices')
            ->andReturn((object) ['data' => 'allInvoices']);
        $this->assertEquals(
            (object) ['data' => 'allInvoices'],
            $this->invoices->all()
        );
    }

    public function testGettingAllInvoicesWithParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('invoices?offset=5&limit=10')
            ->andReturn((object) ['data' => 'allInvoices']);
        $params = (new InvoicesInputParams())
            ->setOffset(5)
            ->setLimit(10);
        $this->assertEquals(
            (object) ['data' => 'allInvoices'],
            $this->invoices->all($params)
        );
    }

    public function testGettingAllInvoicesWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('invoices?offset=5&limit=10')
            ->andReturn((object) ['data' => 'allInvoices']);
        $this->assertEquals(
            (object) ['data' => 'allInvoices'],
            $this->invoices->query()
                 ->setOffset(5)
                 ->setLimit(10)
                 ->get()
        );
    }

    public function testGettingAnInvoiceDetail()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices/serialNumber')
            ->andReturn(file_get_contents("tests/stubs/invoice.json"));
        $invoice = $this->invoices->get('serialNumber');
        $this->assertEquals('INV-01-987654', $invoice->serialNumber);
        $this->assertEquals("edb6322b-8e11-48e9-8d6f-6402e445e50d",$invoice->profileId);
        $this->assertEquals("My Company Ltd",$invoice->profileName);
        $this->assertEquals("My Company Ltd",$invoice->billingInformation->legalName);
        $this->assertEquals("GB123456789",$invoice->billingInformation->vatNumber);
        $this->assertEquals("199 Bishopsgate",$invoice->billingInformation->addressLine1);
        $this->assertEquals("Spitalfields",$invoice->billingInformation->addressLine2);
        $this->assertEquals("London",$invoice->billingInformation->city);
        $this->assertEquals("EC2M 3TY",$invoice->billingInformation->postalCode);
        $this->assertEquals($invoice->billingInformation->countryName, "United Kingdom");
        $this->assertEquals("reseller",$invoice->mode);
        $this->assertEquals("paid",$invoice->status);
        $this->assertEquals("2020-03-31",$invoice->issuingDate);
        $this->assertEquals("monthly",$invoice->billingPeriod);
        $this->assertEquals( "2020-03-01",$invoice->fromDate);
        $this->assertEquals("2020-03-31",$invoice->toDate);
        $this->assertEquals("2020-04-15",$invoice->dueDate);
        $this->assertEquals("EUR",$invoice->currency);
        $this->assertEquals("13579.24",$invoice->total);
        $this->assertEquals(15,$invoice->lines->total);
        //TODO: This is missing
        //$this->assertEquals([],$invoice->lines->data);
        $this->assertEquals($invoice->lines->next, "/invoices/lines?serial_number=INV-01-987654&offset=10");
        $this->assertEquals(2,count($invoice->taxesSummary));
        $this->assertEquals("STAR",$invoice->taxesSummary[0]->taxRegime);
        $this->assertEquals("6543.21",$invoice->taxesSummary[0]->subtotal);
        $this->assertEquals("0.00",$invoice->taxesSummary[0]->taxPercentage);
        $this->assertEquals("0.00",$invoice->taxesSummary[0]->taxAmount);
        $this->assertEquals($invoice->taxesSummary[0]->total,"6543.21");
        $this->assertEquals("G-VAT-R",$invoice->taxesSummary[1]->taxRegime);
        $this->assertEquals("5912.63",$invoice->taxesSummary[1]->subtotal);
        $this->assertEquals("19.00",$invoice->taxesSummary[1]->taxPercentage);
        $this->assertEquals("1123.40",$invoice->taxesSummary[1]->taxAmount);
        $this->assertEquals($invoice->taxesSummary[1]->total, "7036.03");
        $this->assertEquals("My Company Ltd - SEPA - Monthly 2020-03",$invoice->reference);
        $this->assertEquals("La Caixa",$invoice->travelperkBankAccount->bankName);
        $this->assertEquals("ES01 2345 6789 1098 7654 3210",$invoice->travelperkBankAccount->accountNumber);
        $this->assertEquals("CAIX ES BB XXX",$invoice->travelperkBankAccount->bic);
        $this->assertEquals($invoice->travelperkBankAccount->reference, "INV-01-987654");
        $this->assertEquals($invoice->pdf, "https://api.travelperk.com/invoices/INV-01-987654/pdf");
    }

    public function testGettingAnInvoicePDF()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices/serialNumber/pdf')
            ->andReturn('invoicePDF');
        $this->assertEquals(
            'invoicePDF',
            $this->invoices->pdf('serialNumber')
        );
    }

    public function testGettingAllInvoiceLinesWithParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('invoices/lines?offset=5&limit=10')
            ->andReturn((object) ['data' => 'invoiceLines']);
        $params = (new InvoiceLinesInputParams())
            ->setOffset(5)
            ->setLimit(10);
        $this->assertEquals(
            (object) ['data' => 'invoiceLines'],
            $this->invoices->lines($params)
        );
    }

    public function testGettingAllInvoiceLinesWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('invoices/lines?offset=5&limit=10')
            ->andReturn((object) ['data' => 'invoiceLines']);
        $this->assertEquals(
            (object) ['data' => 'invoiceLines'],
            $this->invoices->linesQuery()
                ->setOffset(5)
                ->setLimit(10)
                ->get()
        );
    }

    public function testGettingAllInvoiceLinesNoParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('invoices/lines')
            ->andReturn((object) ['data' => 'invoiceLines']);
        $this->assertEquals(
            (object) ['data' => 'invoiceLines'],
            $this->invoices->lines()
        );
    }

    public function testGettingAllBillingPeriods()
    {
        $this->assertEquals(
            [
                'instant',
                'weekly',
                'biweekly',
                'monthly',
            ],
            $this->invoices->billingPeriods()
        );
    }

    public function testGettingAllStatuses()
    {
        $this->assertEquals(
            [
                'draft',
                'open',
                'paid',
                'unpaid',
            ],
            $this->invoices->statuses()
        );
    }

    public function testGettingAllSortingValues()
    {
        $this->assertEquals(
            [
                'issuing_date',
                '-issuing_date',
            ],
            $this->invoices->sorting()
        );
    }
}
