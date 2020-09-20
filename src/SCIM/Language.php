<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\BasicEnum;

class Language extends BasicEnum
{
    const ENGLISH = 'en';
    const FRENCH = 'fr';
    const DEUTCH = 'de';
    const SPANISH = 'es';

    private $status;

    public function __construct(string $status)
    {
        parent::checkValidity($status);
        $this->status = $status;
    }

    public function __toString()
    {
        return $this->status;
    }
}
