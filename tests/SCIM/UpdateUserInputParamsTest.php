<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\UpdateUserInputParams;

class UpdateUserInputParamTest extends TestCase
{
    public function testSettingUpdateUserInputParams()
    {
        $inputParams = new UpdateUserInputParams();
        $inputParams->setUserName('New user name');
        $this->assertEquals(
            [
                'userName' => 'New user name',
            ],
            $inputParams->asArray()
        );
    }
}
