<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Users;

use Carbon\Carbon;

class UsersInputParams
{
    private $tripId;
    private $offset;
    private $limit;

    public function setTripId(string $tripId): UsersInputParams
    {
        $this->profileId = $profileId;

        return $this;
    }

    public function setOffset(int $offset): UsersInputParams
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): UsersInputParams
    {
        $this->limit = $limit;

        return $this;
    }

    public function asUrlParam(): string
    {
        return http_build_query([
            'trip_id '                       => $this->tripId,
            'offset'                         => $this->offset,
            'limit'                          => $this->limit,
        ]);
    }
}
