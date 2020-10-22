<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\BasicEnum;

class Gender extends BasicEnum
{
    const MALE = 'M';
    const FEMALE = 'F';

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
