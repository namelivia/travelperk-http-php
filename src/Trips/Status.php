<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use Namelivia\TravelPerk\BasicEnum;

class Status extends BasicEnum
{
    const BOOKED = 'booked';
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
