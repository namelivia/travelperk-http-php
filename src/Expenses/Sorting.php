<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\BasicEnum;

class Sorting extends BasicEnum
{
    const ISSUING_DATE_ASC = 'issuing_date';
    const ISSUING_DATE_DESC = '-issuing_date';

    private $sorting;

    public function __construct(string $sorting)
    {
        parent::checkValidity($sorting);
        $this->sorting = $sorting;
    }

    public function __toString()
    {
        return $this->sorting;
    }
}
