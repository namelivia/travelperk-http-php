<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

class BookingsInputParams
{
    private $modifiedGte;
    private $modifiedLt;
    private $status;
    private $offset;
    private $limit;

    public function setModifiedLt(Carbon $modifiedLt): BookingsInputParams
    {
        $this->modifiedLt = $modifiedLt;

        return $this;
    }

    public function setModifiedGte(Carbon $modifiedGte): BookingsInputParams
    {
        $this->modifiedGte = $modifiedGte;

        return $this;
    }

    public function setStatus(string $status): BookingsInputParams
    {
        $this->status = new BookingStatus($status);

        return $this;
    }

    public function setType(string $type): BookingsInputParams
    {
        $this->type = new Type($type);

        return $this;
    }

    public function setOffset(int $offset): BookingsInputParams
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): BookingsInputParams
    {
        $this->limit = $limit;

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'modified_lt'                    => isset($this->modifiedLt) ? $this->modifiedLt->format('Y-m-d') : null,
            'modified_gte'                   => isset($this->modifiedGte) ? $this->modifiedGte->format('Y-m-d') : null,
            'status'                         => isset($this->status) ? strval($this->status) : null,
            'type'                           => isset($this->type) ? strval($this->type) : null,
            'offset'                         => $this->offset,
            'limit'                          => $this->limit,
        ]);
    }
}
