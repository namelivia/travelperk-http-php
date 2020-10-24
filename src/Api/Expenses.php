<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Expenses\InvoiceProfiles;
use Namelivia\TravelPerk\Expenses\Invoices;

class Expenses
{
    private $invoiceProfiles;
    private $invoices;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->invoiceProfiles = new InvoiceProfiles($travelPerk, $mapper);
        $this->invoices = new Invoices($travelPerk, $mapper);
    }

    public function invoiceProfiles(): InvoiceProfiles
    {
        return $this->invoiceProfiles;
    }

    public function invoices(): Invoices
    {
        return $this->invoices;
    }
}
