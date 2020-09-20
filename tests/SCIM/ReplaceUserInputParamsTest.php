<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\SCIM\NameInputParams;
use Namelivia\TravelPerk\SCIM\ReplaceUserInputParams;
use Namelivia\TravelPerk\SCIM\Language;
use Namelivia\TravelPerk\SCIM\Gender;
use Carbon\Carbon;

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
        $inputParams = new ReplaceUserInputParams('username', true, (new NameInputParams('given_name', 'family_name')));
        $inputParams->setLanguage(new Language(Language::SPANISH))
            ->setLocale('en-gb')
            ->setTitle('Manager')
            ->setExternalId('external-id')
            ->setPhoneNumber('787281928')
            ->setGender(new Gender(Gender::MALE))
            ->setDateOfBirth(Carbon::create(1990,3,23))
            ->setTravelPolicy('Travel Policy');
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
                    ]
                ],
                'gender' => 'M',
                'dateOfBirth' => '1990/03/23',
                'travelPolicy' => 'Travel Policy',
            ],
            $inputParams->asArray()
        );
    }
}
