<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class UsersInputParams
{
    private $count;
    private $startIndex;
    private $filter;

    public function setCount(int $count)
    {
        $this->count = $count;

        return $this;
    }

    public function setStartIndex(int $startIndex)
    {
        $this->startIndex = $startIndex;

        return $this;
    }

    public function setFilter(string $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    public function asUrlParam()
    {
        return http_build_query([
            'count'      => $this->count,
            'startIndex' => $this->startIndex,
            'filter'     => $this->filter,
        ]);
    }
}
