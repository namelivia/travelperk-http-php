<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk;

use JsonMapper\JsonMapperFactory;
use Namelivia\TravelPerk\Responses\Invoice;
use JsonMapper\Middleware\CaseConversion;
use JsonMapper\Enums\TextNotation;

class ResponseMapper
{
    public function __construct()
    {
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
    }

    public function mapInvoice(string $invoiceJson): Invoice
    {
        $invoice = new Invoice();
        $this->mapper->mapObject(json_decode($invoiceJson), $invoice);
        return $invoice;
    }
}
