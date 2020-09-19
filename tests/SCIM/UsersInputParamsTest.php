<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\SCIM\UsersInputParams;

class UsersInputParamTest extends TestCase
{
    public function testSettingUsersAllInputParams()
    {
        $inputParams = new UsersInputParams();
        $inputParams->setCount(4)
            ->setStartIndex(3)
            ->setFilter('filter');
        $this->assertEquals(
            'count=4&'.
            'startIndex=3&'.
            'filter=filter',
            urldecode($inputParams->asUrlParam())
        );
    }

    public function testSettingUsersSomeInputParams()
    {
        $inputParams = new UsersInputParams();
        $inputParams->setStartIndex(3);
        $this->assertEquals(
            'startIndex=3',
            urldecode($inputParams->asUrlParam())
        );
    }

    public function testSettingUsersNoInputParams()
    {
        $inputParams = new UsersInputParams();
        $this->assertEquals('', urldecode($inputParams->asUrlParam()));
    }
}
