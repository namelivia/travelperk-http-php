<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Trips;

use Namelivia\TravelPerk\BasicEnum;

class Type extends BasicEnum
{
    const FLIGHT = 'flight';
    const HOTEL = 'hotel';
    const TRAIN = 'train';
    const CAR = 'car';
    const OTHER = 'other';

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
