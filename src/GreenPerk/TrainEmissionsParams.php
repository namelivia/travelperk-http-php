<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\GreenPerk;

class TrainEmissionsParams
{
    private $originId;
    private $destinationId;
    private $vendor;

    public function __construct(string $originId, string $destinationId, string $vendor = null)
    {
        $this->originId = $originId;
        $this->destinationId = $destinationId;
        $this->vendor = $vendor;
    }

    public function asUrlParam(): string
    {
        return http_build_query(array_filter([
            'origin_id'                        => $this->originId,
            'destination_id'                         => $this->destinationId,
            'vendor'                          => $this->vendor ? $this->vendor : null,
        ]));
    }
}
