<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\SCIM\NameInputParams;
use Namelivia\TravelPerk\SCIM\ReplaceUserInputParams;

class ReplaceUserInputParamTest extends TestCase
{
    public function testSettingReplaceUserInputParams()
    {
        $inputParams = new ReplaceUserInputParams('username', true, (new NameInputParams('given_name', 'family_name')));
        $this->assertEquals(
            [
                'userName' => 'username',
                'name'     => [
                    'givenName'  => 'given_name',
                    'familyName' => 'family_name',
                ],
                'active' => true,
            ],
            $inputParams->asArray()
        );
    }
}
