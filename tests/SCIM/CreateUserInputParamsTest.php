<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\CreateUserInputParams;
use Namelivia\TravelPerk\SCIM\NameInputParams;

class CreateUserInputParamTest extends TestCase
{
    public function testSettingCreateUserInputParams()
    {
        $inputParams = new CreateUserInputParams('username', true, (new NameInputParams('given_name', 'family_name')));
        $this->assertEquals(
            [
                'userName' => 'username',
                'name' => [
                    'givenName' => 'given_name',
                    'familyName' => 'family_name',
                ],
                'active' => true,
            ],
            $inputParams->asArray()
        );
    }
}
