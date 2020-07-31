<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Pagination;

class Pagination
{
    private $offset;
    private $limit;
    private $total;

    public function __construct(int $offset, int $limit, int $total)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->total = $total;
    }

    public function asUrlParam()
    {
        return http_build_query([
            'offset' => $this->offset,
            'limit' => $this->limit,
            'total' => $this->total,
        ]);
    }
}
