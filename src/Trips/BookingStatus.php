<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use Namelivia\TravelPerk\BasicEnum;

class BookingStatus extends BasicEnum
{
    const CONFIRMED = 'confirmed';
    const CANCELLED = 'cancelled';

    private $status;

    public function __construct(string $status)
    {
        parent::checkValidity($status);
        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
