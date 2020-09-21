<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\SCIM\NameInputParams;

class NameInputParamsTest extends TestCase
{
    public function testSettingJustMandatoryFields()
    {
        $this->assertEquals(
            [
                'givenName'  => 'Given Name',
                'familyName' => 'Family Name',
            ],
            (new NameInputParams('Given Name', 'Family Name'))->asArray()
        );
    }

    public function testSettingAllFields()
    {
        $this->assertEquals(
            [
                'givenName'       => 'Given Name',
                'familyName'      => 'Family Name',
                'honorificPrefix' => 'Honorific Prefix',
                'middleName'      => 'Middle Name',
            ],
            (new NameInputParams('Given Name', 'Family Name'))
                ->setMiddleName('Middle Name')
                ->setHonorificPrefix('Honorific Prefix')
                ->asArray()
        );
    }
}
