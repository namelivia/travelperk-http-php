<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\BasicEnum;
use Namelivia\TravelPerk\Tests\BasicEnumForTest;
use Namelivia\TravelPerk\Exceptions\InvalidConstantValueException;

class BasicEnumTest extends TestCase
{
    public function testCheckingValidity()
    {
        $valid = new BasicEnumForTest(BasicEnumForTest::VALUE_1);
        $valid = new BasicEnumForTest('value1');
        $this->expectException(InvalidConstantValueException::class);
        $this->expectExceptionMessage('The value value3 is not a valid Namelivia\TravelPerk\Tests\BasicEnumForTest value');
        new BasicEnumForTest('value3');
    }
}
