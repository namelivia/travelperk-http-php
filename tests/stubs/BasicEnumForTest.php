<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\BasicEnum;

class BasicEnumForTest extends BasicEnum
{
    const VALUE_1 = 'value1';
    const VALUE_2 = 'value2';

    private $value;

    public function __construct(string $value)
    {
        parent::checkValidity($value);
        $this->value = $value;
    }
}
