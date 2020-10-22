<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

class InvoiceProfilesInputParams
{
    private $offset;
    private $limit;

    public function setOffset(int $offset): InvoiceProfilesInputParams
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): InvoiceProfilesInputParams
    {
        $this->limit = $limit;

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'offset' => $this->offset,
            'limit'  => $this->limit,
        ]);
    }
}
