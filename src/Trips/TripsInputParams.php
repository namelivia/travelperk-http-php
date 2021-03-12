<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

class TripsInputParams
{
    private $modifiedGte;
    private $modifiedLt;
    private $status;
    private $offset;
    private $limit;

    public function setModifiedLt(Carbon $modifiedLt): TripsInputParams
    {
        $this->modifiedLt = $modifiedLt;

        return $this;
    }

    public function setModifiedGte(Carbon $modifiedGte): TripsInputParams
    {
        $this->modifiedGte = $modifiedGte;

        return $this;
    }

    public function setStatus(string $status): TripsInputParams
    {
        $this->status = new Status($status);

        return $this;
    }

    public function setOffset(int $offset): TripsInputParams
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): TripsInputParams
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
            'offset'                         => $this->offset,
            'limit'                          => $this->limit,
        ]);
    }
}
