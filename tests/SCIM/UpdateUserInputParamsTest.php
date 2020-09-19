<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\UpdateUserInputParams;
use Namelivia\TravelPerk\SCIM\NameInputParams;

class UpdateUserInputParamTest extends TestCase
{
    public function testSettingUpdateUserInputParamsNoName()
    {
        $inputParams = new UpdateUserInputParams();
        $inputParams->setUserName('New user name')
            ->setActive(false);
        $this->assertEquals(
            [
                'userName' => 'New user name',
                'active' => false,
            ],
            $inputParams->asArray()
        );
    }

    public function testSettingUpdateUserInputParamsName()
    {
        $inputParams = new UpdateUserInputParams();
        $inputParams->setName(new NameInputParams('given name', 'family name'));
        $this->assertEquals(
            [
                'name' => [
                    'givenName' => 'given name',
                    'familyName' => 'family name',
                ]
            ],
            $inputParams->asArray()
        );
    }
}
