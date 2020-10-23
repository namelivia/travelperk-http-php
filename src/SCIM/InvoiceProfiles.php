<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class InvoiceProfiles
{
    private $invoiceProfiles;

    public function __construct(array $invoiceProfiles)
    {
        $this->invoiceProfiles = $invoiceProfiles;
    }

    public function asArray(): array
    {
        return array_map(function ($invoiceProfile) {
            return ['value' => $invoiceProfile];
        }, $this->invoiceProfiles);
    }
}
