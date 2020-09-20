<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\SCIM\CreateUserInputParams;
use Namelivia\TravelPerk\SCIM\NameInputParams;
use Namelivia\TravelPerk\SCIM\Language;
use Namelivia\TravelPerk\SCIM\PhoneNumber;
use Namelivia\TravelPerk\SCIM\Gender;
use Namelivia\TravelPerk\SCIM\EmergencyContact;
use Carbon\Carbon;

class CreateUserInputParamTest extends TestCase
{
    public function testSettingCreateUserInputParams()
    {
        $inputParams = new CreateUserInputParams('username', true, (new NameInputParams('given_name', 'family_name')));
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

    public function testSettingCreateUserInputParamsWithOptionalParameters()
    {
        $inputParams = new CreateUserInputParams('username', true, (new NameInputParams('given_name', 'family_name')));
        $inputParams->setLanguage(new Language(Language::SPANISH))
            ->setLocale('en-gb')
            ->setTitle('Manager')
            ->setExternalId('external-id')
            ->setPhoneNumber('787281928')
            ->setGender(new Gender(Gender::MALE))
            ->setDateOfBirth(Carbon::create(1990,3,23))
            ->setTravelPolicy('Travel Policy')
            ->setInvoiceProfiles(['Invoice Profile 1', 'Invoice Profile 2'])
            ->setEmergencyContact(new EmergencyContact('Test contact', '679281923'))
            ->setCostCenter('Test Cost Center')
            ->setManager(123);
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
                'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User' => [
                    'gender' => 'M',
                    'dateOfBirth' => '1990/03/23',
                    'travelPolicy' => 'Travel Policy',
                    'emergencyContact' => [
                        'name' => 'Test contact',
                        'phone' => '679281923',
                    ],
                    'invoiceProfiles' => [
                        ['value' => 'Invoice Profile 1'],
                        ['value' => 'Invoice Profile 2'],
                    ],
                ],
                'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User' => [
                    'costCenter' => 'Test Cost Center',
                    'manager' => [
                        'value' => 123
                    ],
                ],
            ],
            $inputParams->asArray()
        );
    }
}
