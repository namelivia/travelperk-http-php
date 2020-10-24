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

    private function assertEqualsStub($invoiceLinesPage): void
    {
        $this->assertEquals(1, $invoiceLinesPage->total);
        $this->assertEquals(0, $invoiceLinesPage->offset);
        $this->assertEquals(10, $invoiceLinesPage->limit);
        $this->assertEquals(1, count($invoiceLinesPage->invoiceLines));
        $this->assertEquals("2020-02-13", $invoiceLinesPage->invoiceLines[0]->expenseDate);
        $this->assertEquals("FLIGHT for Trip ID 1687664", $invoiceLinesPage->invoiceLines[0]->description);
        $this->assertEquals(1, $invoiceLinesPage->invoiceLines[0]->quantity);
        $this->assertEquals("20.00000000", $invoiceLinesPage->invoiceLines[0]->unitPrice);
        $this->assertEquals("0E-8", $invoiceLinesPage->invoiceLines[0]->nonTaxableUnitPrice);
        $this->assertEquals("0E-8", $invoiceLinesPage->invoiceLines[0]->taxPercentage);
        $this->assertEquals("0E-8", $invoiceLinesPage->invoiceLines[0]->taxAmount);
        $this->assertEquals("STAR", $invoiceLinesPage->invoiceLines[0]->taxRegime);
        $this->assertEquals("20.00000000", $invoiceLinesPage->invoiceLines[0]->totalAmount);
        $this->assertEquals("INV-01-190111", $invoiceLinesPage->invoiceLines[0]->invoiceSerialNumber);
        $this->assertEquals("09d649d1-35fa-4d9f-b688-046d5790afd2", $invoiceLinesPage->invoiceLines[0]->profileId);
        $this->assertEquals("My Company Ltd", $invoiceLinesPage->invoiceLines[0]->profileName);
        $this->assertEquals("reseller", $invoiceLinesPage->invoiceLines[0]->invoiceMode);
        $this->assertEquals("paid", $invoiceLinesPage->invoiceLines[0]->invoiceStatus);
        $this->assertEquals("2020-02-13", $invoiceLinesPage->invoiceLines[0]->issuingDate);
        $this->assertEquals("2020-02-13", $invoiceLinesPage->invoiceLines[0]->dueDate);
        $this->assertEquals("EUR", $invoiceLinesPage->invoiceLines[0]->currency);
        $this->assertEquals(1687664, $invoiceLinesPage->invoiceLines[0]->metadata->tripId);
        $this->assertEquals("Meeting with German company GmbH", $invoiceLinesPage->invoiceLines[0]->metadata->tripName);
        $this->assertEquals("flight", $invoiceLinesPage->invoiceLines[0]->metadata->service);
        $this->assertEquals(1, count($invoiceLinesPage->invoiceLines[0]->metadata->travelers));
        $this->assertEquals("John Doe", $invoiceLinesPage->invoiceLines[0]->metadata->travelers[0]->name);
        $this->assertEquals("john.doe@mycompany.com", $invoiceLinesPage->invoiceLines[0]->metadata->travelers[0]->email);
        $this->assertEquals("ASD123", $invoiceLinesPage->invoiceLines[0]->metadata->travelers[0]->externalId);
        $this->assertEquals("2020-03-27", $invoiceLinesPage->invoiceLines[0]->metadata->startDate);
        $this->assertEquals("2020-04-05", $invoiceLinesPage->invoiceLines[0]->metadata->endDate);
        $this->assertEquals("DACH Accounts", $invoiceLinesPage->invoiceLines[0]->metadata->costCenter);
        $this->assertEquals([ "Sales trips", "Special"], $invoiceLinesPage->invoiceLines[0]->metadata->labels);
        $this->assertEquals("LH", $invoiceLinesPage->invoiceLines[0]->metadata->vendor->code);
        $this->assertEquals("Lufthansa", $invoiceLinesPage->invoiceLines[0]->metadata->vendor->name);
        $this->assertEquals(false, $invoiceLinesPage->invoiceLines[0]->metadata->outOfPolicy);
        $this->assertEquals(1, count($invoiceLinesPage->invoiceLines[0]->metadata->approvers));
        $this->assertEquals("Jake Bolt", $invoiceLinesPage->invoiceLines[0]->metadata->approvers[0]->name);
        $this->assertEquals("jake.bolt@mycompany.com", $invoiceLinesPage->invoiceLines[0]->metadata->approvers[0]->email);
        $this->assertEquals("ASD124", $invoiceLinesPage->invoiceLines[0]->metadata->approvers[0]->externalId);
        $this->assertEquals("Marien Lint", $invoiceLinesPage->invoiceLines[0]->metadata->booker->name);
        $this->assertEquals("marien.lint@mycompany.com", $invoiceLinesPage->invoiceLines[0]->metadata->booker->email);
        $this->assertEquals("ASD124", $invoiceLinesPage->invoiceLines[0]->metadata->booker->externalId);
    }

    private function assertEqualsInvoicesStub($invoicesPage): void
    {
        $this->assertEquals(1, $invoicesPage->total);
        $this->assertEquals(0, $invoicesPage->offset);
        $this->assertEquals(10, $invoicesPage->limit);
        $this->assertEquals(1, count($invoicesPage->invoices));
        $this->assertEquals('INV-01-987654', $invoicesPage->invoices[0]->serialNumber);
        $this->assertEquals("edb6322b-8e11-48e9-8d6f-6402e445e50d",$invoicesPage->invoices[0]->profileId);
        $this->assertEquals("My Company Ltd",$invoicesPage->invoices[0]->profileName);
        $this->assertEquals("My Company Ltd",$invoicesPage->invoices[0]->billingInformation->legalName);
        $this->assertEquals("GB123456789",$invoicesPage->invoices[0]->billingInformation->vatNumber);
        $this->assertEquals("199 Bishopsgate",$invoicesPage->invoices[0]->billingInformation->addressLine1);
        $this->assertEquals("Spitalfields",$invoicesPage->invoices[0]->billingInformation->addressLine2);
        $this->assertEquals("London",$invoicesPage->invoices[0]->billingInformation->city);
        $this->assertEquals("EC2M 3TY",$invoicesPage->invoices[0]->billingInformation->postalCode);
        $this->assertEquals($invoicesPage->invoices[0]->billingInformation->countryName, "United Kingdom");
        $this->assertEquals("reseller",$invoicesPage->invoices[0]->mode);
        $this->assertEquals("paid",$invoicesPage->invoices[0]->status);
        $this->assertEquals("2020-03-31",$invoicesPage->invoices[0]->issuingDate);
        $this->assertEquals("monthly",$invoicesPage->invoices[0]->billingPeriod);
        $this->assertEquals( "2020-03-01",$invoicesPage->invoices[0]->fromDate);
        $this->assertEquals("2020-03-31",$invoicesPage->invoices[0]->toDate);
        $this->assertEquals("2020-04-15",$invoicesPage->invoices[0]->dueDate);
        $this->assertEquals("EUR",$invoicesPage->invoices[0]->currency);
        $this->assertEquals("13579.24",$invoicesPage->invoices[0]->total);
        $this->assertEquals(15,$invoicesPage->invoices[0]->lines->total);
        //TODO: This is missing
        //$this->assertEquals([],$invoicesPage->invoices[0]->lines->data);
        $this->assertEquals($invoicesPage->invoices[0]->lines->next, "/invoices/lines?serial_number=INV-01-987654&offset=10");
        $this->assertEquals(2,count($invoicesPage->invoices[0]->taxesSummary));
        $this->assertEquals("STAR",$invoicesPage->invoices[0]->taxesSummary[0]->taxRegime);
        $this->assertEquals("6543.21",$invoicesPage->invoices[0]->taxesSummary[0]->subtotal);
        $this->assertEquals("0.00",$invoicesPage->invoices[0]->taxesSummary[0]->taxPercentage);
        $this->assertEquals("0.00",$invoicesPage->invoices[0]->taxesSummary[0]->taxAmount);
        $this->assertEquals($invoicesPage->invoices[0]->taxesSummary[0]->total,"6543.21");
        $this->assertEquals("G-VAT-R",$invoicesPage->invoices[0]->taxesSummary[1]->taxRegime);
        $this->assertEquals("5912.63",$invoicesPage->invoices[0]->taxesSummary[1]->subtotal);
        $this->assertEquals("19.00",$invoicesPage->invoices[0]->taxesSummary[1]->taxPercentage);
        $this->assertEquals("1123.40",$invoicesPage->invoices[0]->taxesSummary[1]->taxAmount);
        $this->assertEquals($invoicesPage->invoices[0]->taxesSummary[1]->total, "7036.03");
        $this->assertEquals("My Company Ltd - SEPA - Monthly 2020-03",$invoicesPage->invoices[0]->reference);
        $this->assertEquals("La Caixa",$invoicesPage->invoices[0]->travelperkBankAccount->bankName);
        $this->assertEquals("ES01 2345 6789 1098 7654 3210",$invoicesPage->invoices[0]->travelperkBankAccount->accountNumber);
        $this->assertEquals("CAIX ES BB XXX",$invoicesPage->invoices[0]->travelperkBankAccount->bic);
        $this->assertEquals($invoicesPage->invoices[0]->travelperkBankAccount->reference, "INV-01-987654");
        $this->assertEquals($invoicesPage->invoices[0]->pdf, "https://api.travelperk.com/invoices/INV-01-987654/pdf");
    }

    public function testGettingAllInvoicesNoParams()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices')
            ->andReturn(file_get_contents("tests/stubs/invoices.json"));
        $invoices = $this->invoices->all();
        $this->assertEqualsInvoicesStub($invoices);
    }

    public function testGettingAllInvoicesWithParams()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices?offset=5&limit=10')
            ->andReturn(file_get_contents("tests/stubs/invoices.json"));
        $params = (new InvoicesInputParams())
            ->setOffset(5)
            ->setLimit(10);
        $invoices = $this->invoices->all($params);
        $this->assertEqualsInvoicesStub($invoices);
    }

    public function testGettingAllInvoicesWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices?offset=5&limit=10')
            ->andReturn(file_get_contents("tests/stubs/invoices.json"));
        $invoices = $this->invoices->query()
             ->setOffset(5)
             ->setLimit(10)
             ->get();
        $this->assertEqualsInvoicesStub($invoices);
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
        $this->assertEquals(1,$invoice->lines->total);
        $this->assertEquals(1,count($invoice->lines->data));
        $this->assertEquals("2020-02-13", $invoice->lines->data[0]->expenseDate);
        $this->assertEquals("FLIGHT for Trip ID 1687664", $invoice->lines->data[0]->description);
        $this->assertEquals(1, $invoice->lines->data[0]->quantity);
        $this->assertEquals("20.00000000", $invoice->lines->data[0]->unitPrice);
        $this->assertEquals("0E-8", $invoice->lines->data[0]->nonTaxableUnitPrice);
        $this->assertEquals("0E-8", $invoice->lines->data[0]->taxPercentage);
        $this->assertEquals("0E-8", $invoice->lines->data[0]->taxAmount);
        $this->assertEquals("STAR", $invoice->lines->data[0]->taxRegime);
        $this->assertEquals("20.00000000", $invoice->lines->data[0]->totalAmount);
        $this->assertEquals("INV-01-190111", $invoice->lines->data[0]->invoiceSerialNumber);
        $this->assertEquals("09d649d1-35fa-4d9f-b688-046d5790afd2", $invoice->lines->data[0]->profileId);
        $this->assertEquals("My Company Ltd", $invoice->lines->data[0]->profileName);
        $this->assertEquals("reseller", $invoice->lines->data[0]->invoiceMode);
        $this->assertEquals("paid", $invoice->lines->data[0]->invoiceStatus);
        $this->assertEquals("2020-02-13", $invoice->lines->data[0]->issuingDate);
        $this->assertEquals("2020-02-13", $invoice->lines->data[0]->dueDate);
        $this->assertEquals("EUR", $invoice->lines->data[0]->currency);
        $this->assertEquals(1687664, $invoice->lines->data[0]->metadata->tripId);
        $this->assertEquals("Meeting with German company GmbH", $invoice->lines->data[0]->metadata->tripName);
        $this->assertEquals("flight", $invoice->lines->data[0]->metadata->service);
        $this->assertEquals(1, count($invoice->lines->data[0]->metadata->travelers));
        $this->assertEquals("John Doe", $invoice->lines->data[0]->metadata->travelers[0]->name);
        $this->assertEquals("john.doe@mycompany.com", $invoice->lines->data[0]->metadata->travelers[0]->email);
        $this->assertEquals("ASD123", $invoice->lines->data[0]->metadata->travelers[0]->externalId);
        $this->assertEquals("2020-03-27", $invoice->lines->data[0]->metadata->startDate);
        $this->assertEquals("2020-04-05", $invoice->lines->data[0]->metadata->endDate);
        $this->assertEquals("DACH Accounts", $invoice->lines->data[0]->metadata->costCenter);
        $this->assertEquals([ "Sales trips", "Special"], $invoice->lines->data[0]->metadata->labels);
        $this->assertEquals("LH", $invoice->lines->data[0]->metadata->vendor->code);
        $this->assertEquals("Lufthansa", $invoice->lines->data[0]->metadata->vendor->name);
        $this->assertEquals(false, $invoice->lines->data[0]->metadata->outOfPolicy);
        $this->assertEquals(1, count($invoice->lines->data[0]->metadata->approvers));
        $this->assertEquals("Jake Bolt", $invoice->lines->data[0]->metadata->approvers[0]->name);
        $this->assertEquals("jake.bolt@mycompany.com", $invoice->lines->data[0]->metadata->approvers[0]->email);
        $this->assertEquals("ASD124", $invoice->lines->data[0]->metadata->approvers[0]->externalId);
        $this->assertEquals("Marien Lint", $invoice->lines->data[0]->metadata->booker->name);
        $this->assertEquals("marien.lint@mycompany.com", $invoice->lines->data[0]->metadata->booker->email);
        $this->assertEquals("ASD124", $invoice->lines->data[0]->metadata->booker->externalId);
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
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices/lines?offset=5&limit=10')
            ->andReturn(file_get_contents("tests/stubs/invoiceLines.json"));
        $params = (new InvoiceLinesInputParams())
            ->setOffset(5)
            ->setLimit(10);
        $invoiceLines= $this->invoices->lines($params);
        $this->assertEqualsStub($invoiceLines);
    }

    public function testGettingAllInvoiceLinesWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices/lines?offset=5&limit=10')
            ->andReturn(file_get_contents("tests/stubs/invoiceLines.json"));
        $invoiceLines = $this->invoices->linesQuery()
            ->setOffset(5)
            ->setLimit(10)
            ->get();
        $this->assertEqualsStub($invoiceLines);
    }

    public function testGettingAllInvoiceLinesNoParams()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('invoices/lines')
            ->andReturn(file_get_contents("tests/stubs/invoiceLines.json"));
        $invoiceLines = $this->invoices->lines();
        $this->assertEqualsStub($invoiceLines);
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

