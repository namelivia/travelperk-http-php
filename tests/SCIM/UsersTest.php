<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Exceptions\NotImplementedException;
use Namelivia\TravelPerk\SCIM\UpdateUserInputParams;
use Namelivia\TravelPerk\SCIM\Users;
use Namelivia\TravelPerk\SCIM\UsersInputParams;

class UsersTest extends TestCase
{
    private $travelPerk;
    private $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->users = new Users($this->travelPerk, $this->mapper);
    }

    public function testGettingAllUsersNoParams()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Users')
            ->andReturn(file_get_contents('tests/stubs/users.json'));
        $users = $this->users->all();
        $this->assertEquals([
            'urn:ietf:params:scim:api:messages:2.0:ListResponse',
        ], $users->schemas);
        $this->assertEquals(2, $users->totalResults);
        $this->assertEquals(2, $users->itemsPerPage);
        $this->assertEquals(1, $users->startIndex);
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $users->resources[0]->schemas);
        $this->assertEquals('Marlen', $users->resources[0]->name->givenName);
        $this->assertEquals('Col', $users->resources[0]->name->familyName);
        $this->assertEquals('', $users->resources[0]->name->middleName);
        $this->assertEquals('', $users->resources[0]->name->honorificPrefix);
        $this->assertEquals('en', $users->resources[0]->locale);
        $this->assertEquals('en', $users->resources[0]->preferredLanguage);
        $this->assertEquals('Manager', $users->resources[0]->title);
        $this->assertEquals('123455667', $users->resources[0]->externalId);
        $this->assertEquals('29', $users->resources[0]->id);
        $this->assertEquals([], $users->resources[0]->groups);
        $this->assertEquals(true, $users->resources[0]->active);
        $this->assertEquals('marlen.col@mycompany.com', $users->resources[0]->userName);
        $this->assertEquals(1, count($users->resources[0]->phoneNumbers));
        $this->assertEquals('+34 1234567', $users->resources[0]->phoneNumbers[0]->value);
        $this->assertEquals('work', $users->resources[0]->phoneNumbers[0]->type);
        $this->assertEquals('User', $users->resources[0]->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $users->resources[0]->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $users->resources[0]->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $users->resources[0]->meta->location);
        $this->assertEquals('Marketing', $users->resources[0]->enterpriseExtension->costCenter);
        $this->assertEquals('123', $users->resources[0]->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $users->resources[0]->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $users->resources[0]->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $users->resources[0]->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $users->resources[0]->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $users->resources[0]->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($users->resources[0]->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $users->resources[0]->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $users->resources[0]->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $users->resources[0]->travelperkExtension->emergencyContact->phone);
    }

    public function testGettingAllUsersWithParams()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Users?count=5&startIndex=3')
            ->andReturn(file_get_contents('tests/stubs/users.json'));
        $params = (new UsersInputParams())
            ->setCount(5)
            ->setStartIndex(3);
        $users = $this->users->all($params);
        $this->assertEquals(2, $users->totalResults);
        $this->assertEquals(2, $users->itemsPerPage);
        $this->assertEquals(1, $users->startIndex);
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $users->resources[0]->schemas);
        $this->assertEquals('Marlen', $users->resources[0]->name->givenName);
        $this->assertEquals('Col', $users->resources[0]->name->familyName);
        $this->assertEquals('', $users->resources[0]->name->middleName);
        $this->assertEquals('', $users->resources[0]->name->honorificPrefix);
        $this->assertEquals('en', $users->resources[0]->locale);
        $this->assertEquals('en', $users->resources[0]->preferredLanguage);
        $this->assertEquals('Manager', $users->resources[0]->title);
        $this->assertEquals('123455667', $users->resources[0]->externalId);
        $this->assertEquals('29', $users->resources[0]->id);
        $this->assertEquals([], $users->resources[0]->groups);
        $this->assertEquals(true, $users->resources[0]->active);
        $this->assertEquals('marlen.col@mycompany.com', $users->resources[0]->userName);
        $this->assertEquals(1, count($users->resources[0]->phoneNumbers));
        $this->assertEquals('+34 1234567', $users->resources[0]->phoneNumbers[0]->value);
        $this->assertEquals('work', $users->resources[0]->phoneNumbers[0]->type);
        $this->assertEquals('User', $users->resources[0]->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $users->resources[0]->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $users->resources[0]->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $users->resources[0]->meta->location);
        $this->assertEquals('Marketing', $users->resources[0]->enterpriseExtension->costCenter);
        $this->assertEquals('123', $users->resources[0]->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $users->resources[0]->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $users->resources[0]->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $users->resources[0]->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $users->resources[0]->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $users->resources[0]->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($users->resources[0]->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $users->resources[0]->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $users->resources[0]->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $users->resources[0]->travelperkExtension->emergencyContact->phone);
    }

    public function testGettingAllUsersWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Users?count=5&startIndex=3')
            ->andReturn(file_get_contents('tests/stubs/users.json'));
        $users = $this->users->query()
            ->setCount(5)
            ->setStartIndex(3)
            ->get();
        $this->assertEquals(2, $users->totalResults);
        $this->assertEquals(2, $users->itemsPerPage);
        $this->assertEquals(1, $users->startIndex);
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $users->resources[0]->schemas);
        $this->assertEquals('Marlen', $users->resources[0]->name->givenName);
        $this->assertEquals('Col', $users->resources[0]->name->familyName);
        $this->assertEquals('', $users->resources[0]->name->middleName);
        $this->assertEquals('', $users->resources[0]->name->honorificPrefix);
        $this->assertEquals('en', $users->resources[0]->locale);
        $this->assertEquals('en', $users->resources[0]->preferredLanguage);
        $this->assertEquals('Manager', $users->resources[0]->title);
        $this->assertEquals('123455667', $users->resources[0]->externalId);
        $this->assertEquals('29', $users->resources[0]->id);
        $this->assertEquals([], $users->resources[0]->groups);
        $this->assertEquals(true, $users->resources[0]->active);
        $this->assertEquals('marlen.col@mycompany.com', $users->resources[0]->userName);
        $this->assertEquals(1, count($users->resources[0]->phoneNumbers));
        $this->assertEquals('+34 1234567', $users->resources[0]->phoneNumbers[0]->value);
        $this->assertEquals('work', $users->resources[0]->phoneNumbers[0]->type);
        $this->assertEquals('User', $users->resources[0]->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $users->resources[0]->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $users->resources[0]->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $users->resources[0]->meta->location);
        $this->assertEquals('Marketing', $users->resources[0]->enterpriseExtension->costCenter);
        $this->assertEquals('123', $users->resources[0]->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $users->resources[0]->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $users->resources[0]->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $users->resources[0]->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $users->resources[0]->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $users->resources[0]->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($users->resources[0]->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $users->resources[0]->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $users->resources[0]->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $users->resources[0]->travelperkExtension->emergencyContact->phone);
    }

    public function testGettingAUserDetail()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Users/1')
            ->andReturn(file_get_contents('tests/stubs/user.json'));
        $user = $this->users->get(1);
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $user->schemas);
        $this->assertEquals('Marlen', $user->name->givenName);
        $this->assertEquals('Col', $user->name->familyName);
        $this->assertEquals('', $user->name->middleName);
        $this->assertEquals('', $user->name->honorificPrefix);
        $this->assertEquals('en', $user->locale);
        $this->assertEquals('en', $user->preferredLanguage);
        $this->assertEquals('Manager', $user->title);
        $this->assertEquals('123455667', $user->externalId);
        $this->assertEquals('29', $user->id);
        $this->assertEquals([], $user->groups);
        $this->assertEquals(true, $user->active);
        $this->assertEquals('marlen.col@mycompany.com', $user->userName);
        $this->assertEquals(1, count($user->phoneNumbers));
        $this->assertEquals('+34 1234567', $user->phoneNumbers[0]->value);
        $this->assertEquals('work', $user->phoneNumbers[0]->type);
        $this->assertEquals('User', $user->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $user->meta->location);
        $this->assertEquals('Marketing', $user->enterpriseExtension->costCenter);
        $this->assertEquals('123', $user->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $user->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $user->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $user->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $user->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $user->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($user->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $user->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $user->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $user->travelperkExtension->emergencyContact->phone);
    }

    public function testDeletingAUser()
    {
        $this->travelPerk->shouldReceive('delete')
            ->once()
            ->with('scim/Users/1')
            ->andReturn('userDeleted');
        $this->assertEquals(
            'userDeleted',
            $this->users->delete(1)
        );
    }

    public function testMakingAndSavingAUser()
    {
        $this->travelPerk->shouldReceive('post')
            ->once()
            ->with('scim/Users', [
                'userName' => 'testuser@test.com',
                'name'     => [
                    'givenName'       => 'Test',
                    'familyName'      => 'User',
                    'honorificPrefix' => 'Dr',
                ],
                'active' => true,
                'locale' => 'en',
                'title'  => 'manager',
            ])
            ->andReturn(file_get_contents('tests/stubs/user.json'));
        $user = $this->users->make(
            'testuser@test.com',
            true,
            'Test',
            'User',
        )->setHonorificPrefix('Dr')->setLocale('en')->setTitle('manager')->save();
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $user->schemas);
        $this->assertEquals('Marlen', $user->name->givenName);
        $this->assertEquals('Col', $user->name->familyName);
        $this->assertEquals('', $user->name->middleName);
        $this->assertEquals('', $user->name->honorificPrefix);
        $this->assertEquals('en', $user->locale);
        $this->assertEquals('en', $user->preferredLanguage);
        $this->assertEquals('Manager', $user->title);
        $this->assertEquals('123455667', $user->externalId);
        $this->assertEquals('29', $user->id);
        $this->assertEquals([], $user->groups);
        $this->assertEquals(true, $user->active);
        $this->assertEquals('marlen.col@mycompany.com', $user->userName);
        $this->assertEquals(1, count($user->phoneNumbers));
        $this->assertEquals('+34 1234567', $user->phoneNumbers[0]->value);
        $this->assertEquals('work', $user->phoneNumbers[0]->type);
        $this->assertEquals('User', $user->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $user->meta->location);
        $this->assertEquals('Marketing', $user->enterpriseExtension->costCenter);
        $this->assertEquals('123', $user->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $user->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $user->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $user->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $user->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $user->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($user->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $user->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $user->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $user->travelperkExtension->emergencyContact->phone);
    }

    public function testCreatingAUser()
    {
        $this->travelPerk->shouldReceive('post')
            ->once()
            ->with('scim/Users', [
                'userName' => 'testuser@test.com',
                'name'     => [
                    'givenName'  => 'Test',
                    'familyName' => 'User',
                ],
                'active' => true,
            ])
            ->andReturn(file_get_contents('tests/stubs/user.json'));
        $user = $this->users->create(
            'testuser@test.com',
            true,
            'Test',
            'User',
        );
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $user->schemas);
        $this->assertEquals('Marlen', $user->name->givenName);
        $this->assertEquals('Col', $user->name->familyName);
        $this->assertEquals('', $user->name->middleName);
        $this->assertEquals('', $user->name->honorificPrefix);
        $this->assertEquals('en', $user->locale);
        $this->assertEquals('en', $user->preferredLanguage);
        $this->assertEquals('Manager', $user->title);
        $this->assertEquals('123455667', $user->externalId);
        $this->assertEquals('29', $user->id);
        $this->assertEquals([], $user->groups);
        $this->assertEquals(true, $user->active);
        $this->assertEquals('marlen.col@mycompany.com', $user->userName);
        $this->assertEquals(1, count($user->phoneNumbers));
        $this->assertEquals('+34 1234567', $user->phoneNumbers[0]->value);
        $this->assertEquals('work', $user->phoneNumbers[0]->type);
        $this->assertEquals('User', $user->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $user->meta->location);
        $this->assertEquals('Marketing', $user->enterpriseExtension->costCenter);
        $this->assertEquals('123', $user->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $user->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $user->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $user->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $user->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $user->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($user->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $user->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $user->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $user->travelperkExtension->emergencyContact->phone);
    }

    public function testUpdatingAUser()
    {
        $params = Mockery::mock(UpdateUserInputParams::class);
        $userId = 1;
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage('https://github.com/namelivia/travelperk-http-php/issues/7');
        $this->users->update($userId, $params);
    }

    public function testReplacingAUser()
    {
        $userId = 1;
        $this->travelPerk->shouldReceive('put')
            ->once()
            ->with('scim/Users/1', [
                'userName' => 'testuser@test.com',
                'name'     => [
                    'givenName'        => 'Test',
                    'familyName'       => 'User',
                    'honorificPrefix'  => 'Dr',
                ],
                'active' => true,
                'title'  => 'manager',
            ])
            ->andReturn(file_get_contents('tests/stubs/user.json'));
        $user = $this->users->modify(
            $userId,
            'testuser@test.com',
            true,
            'Test',
            'User',
        )->setHonorificPrefix('Dr')->setTitle('manager')->save();
        $this->assertEquals([
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User',
            'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User',
        ], $user->schemas);
        $this->assertEquals('Marlen', $user->name->givenName);
        $this->assertEquals('Col', $user->name->familyName);
        $this->assertEquals('', $user->name->middleName);
        $this->assertEquals('', $user->name->honorificPrefix);
        $this->assertEquals('en', $user->locale);
        $this->assertEquals('en', $user->preferredLanguage);
        $this->assertEquals('Manager', $user->title);
        $this->assertEquals('123455667', $user->externalId);
        $this->assertEquals('29', $user->id);
        $this->assertEquals([], $user->groups);
        $this->assertEquals(true, $user->active);
        $this->assertEquals('marlen.col@mycompany.com', $user->userName);
        $this->assertEquals(1, count($user->phoneNumbers));
        $this->assertEquals('+34 1234567', $user->phoneNumbers[0]->value);
        $this->assertEquals('work', $user->phoneNumbers[0]->type);
        $this->assertEquals('User', $user->meta->resourceType);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->created);
        $this->assertEquals('2020-04-01T22:24:44.137082+00:00', $user->meta->lastModified);
        $this->assertEquals('http://app.travelperk.com/api/v2/scim/Users/29', $user->meta->location);
        $this->assertEquals('Marketing', $user->enterpriseExtension->costCenter);
        $this->assertEquals('123', $user->enterpriseExtension->manager->value);
        $this->assertEquals(
            'https://app.travelperk.com/api/v2/scim/Users/123/',
            $user->enterpriseExtension->manager->ref
        );
        $this->assertEquals('Jack Jackson', $user->enterpriseExtension->manager->displayName);
        $this->assertEquals('M', $user->travelperkExtension->gender);
        $this->assertEquals('1980-02-02', $user->travelperkExtension->dateOfBirth);
        $this->assertEquals('Marketing travel policy', $user->travelperkExtension->travelPolicy);
        $this->assertEquals(1, count($user->travelperkExtension->invoiceProfiles));
        $this->assertEquals('My Company Ltd', $user->travelperkExtension->invoiceProfiles[0]->value);
        $this->assertEquals('Jane Goodie', $user->travelperkExtension->emergencyContact->name);
        $this->assertEquals('+34 9874637', $user->travelperkExtension->emergencyContact->phone);
    }

    public function testGettingAllGenders()
    {
        $this->assertEquals(
            [
                'M',
                'F',
            ],
            $this->users->genders()
        );
    }

    public function testGettingAllLanguages()
    {
        $this->assertEquals(
            [
                'en',
                'fr',
                'de',
                'es',
            ],
            $this->users->languages()
        );
    }
}
