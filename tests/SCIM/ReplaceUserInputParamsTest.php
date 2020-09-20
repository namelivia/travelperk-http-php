<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\SCIM\NameInputParams;
use Namelivia\TravelPerk\SCIM\ReplaceUserInputParams;
use Namelivia\TravelPerk\SCIM\Language;
use Namelivia\TravelPerk\SCIM\PhoneNumber;

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

    public function testSettingReplaceUserInputParamsWithOptionalParameters()
    {
        $phoneNumber = new PhoneNumber('787281928', 'work');
        $phoneNumber2  = new PhoneNumber('61846271', 'personal');
        $inputParams = new ReplaceUserInputParams('username', true, (new NameInputParams('given_name', 'family_name')));
        $inputParams->setLanguage(new Language(Language::SPANISH))
            ->setLocale('en-gb')
            ->setTitle('Manager')
            ->setExternalId('external-id')
            ->addPhoneNumber($phoneNumber)
            ->addPhoneNumber($phoneNumber2);
        $this->assertEquals(
            [
                'userName' => 'username',
                'name'     => [
                    'givenName'  => 'given_name',
                    'familyName' => 'family_name',
                ],
                'active' => true,
                'preferredLanguage' => 'es',
                'locale' => 'en-gb',
                'title' => 'Manager',
                'externalId' => 'external-id',
                'phoneNumbers' => [
                    [
                        'value' => '787281928',
                        'type' => 'work',
                    ],
                    [
                        'value' => '61846271',
                        'type' => 'personal',
                    ]
                ],
            ],
            $inputParams->asArray()
        );
    }
}
