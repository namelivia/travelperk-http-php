<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class UsersInputParams
{
    private $count;
    private $startIndex;
    private $filter;

    public function setCount(int $count): UsersInputParams
    {
        $this->count = $count;

        return $this;
    }

    public function setStartIndex(int $startIndex): UsersInputParams
    {
        $this->startIndex = $startIndex;

        return $this;
    }

    public function setFilter(string $filter): UsersInputParams
    {
        $this->filter = $filter;

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'count'      => $this->count,
            'startIndex' => $this->startIndex,
            'filter'     => $this->filter,
        ]);
    }
}
