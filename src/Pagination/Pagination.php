<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Pagination;

class Pagination
{
    private $offset;
    private $limit;

    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function asUrlParam()
    {
        return http_build_query([
            'offset' => $this->offset,
            'limit' => $this->limit
        ]);
    }
}
