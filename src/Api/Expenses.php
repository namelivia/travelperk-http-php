<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use Namelivia\TravelPerk\Expenses\InvoiceProfiles;
use Namelivia\TravelPerk\Expenses\Invoices;

class Expenses
{
    private $invoiceProfiles;
    private $invoices;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->invoiceProfiles = new InvoiceProfiles($travelPerk);
        $this->invoices = new Invoices($travelPerk);
    }

    public function invoiceProfiles()
    {
        return $this->invoiceProfiles;
    }

    public function invoices()
    {
        return $this->invoices;
    }
}
