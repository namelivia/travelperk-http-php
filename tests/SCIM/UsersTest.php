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
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users')
            ->andReturn((object) ['data' => 'allUsers']);
        $this->assertEquals(
            (object) ['data' => 'allUsers'],
            $this->users->all()
        );
    }

    public function testGettingAllUsersWithParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users?count=5&startIndex=3')
            ->andReturn((object) ['data' => 'allUsers']);
        $params = (new UsersInputParams())
            ->setCount(5)
            ->setStartIndex(3);
        $this->assertEquals(
            (object) ['data' => 'allUsers'],
            $this->users->all($params)
        );
    }

    public function testGettingAllUsersWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users?count=5&startIndex=3')
            ->andReturn((object) ['data' => 'allUsers']);
        $this->assertEquals(
            (object) ['data' => 'allUsers'],
            $this->users->query()
            ->setCount(5)
            ->setStartIndex(3)
            ->get()
        );
    }

    public function testGettingAUserDetail()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Users/1')
            ->andReturn(file_get_contents('tests/stubs/user.json'));
        $user = $this->users->get(1);
        $this->assertEquals([
            "urn:ietf:params:scim:schemas:core:2.0:User",
            "urn:ietf:params:scim:schemas:extension:enterprise:2.0:User",
            "urn:ietf:params:scim:schemas:extension:travelperk:2.0:User"
        ], $user->schemas);
        $this->assertEquals("Marlen", $user->name->givenName);
        $this->assertEquals("Col", $user->name->familyName);
        $this->assertEquals("", $user->name->middleName);
        $this->assertEquals("", $user->name->honorificPrefix);
        $this->assertEquals("en", $user->locale);
        $this->assertEquals("en", $user->preferredLanguage);
        $this->assertEquals("Manager", $user->title);
        $this->assertEquals("123455667", $user->externalId);
        $this->assertEquals("29", $user->id);
        $this->assertEquals([], $user->groups);
        $this->assertEquals(true, $user->active);
        $this->assertEquals("marlen.col@mycompany.com", $user->userName);
        $this->assertEquals(1 , count($user->phoneNumbers));
        $this->assertEquals("+34 1234567", $user->phoneNumbers[0]->value);
        $this->assertEquals("work", $user->phoneNumbers[0]->type);
        $this->assertEquals("User", $user->meta->resourceType);
        $this->assertEquals("2020-04-01T22:24:44.137082+00:00", $user->meta->created);
        $this->assertEquals("2020-04-01T22:24:44.137082+00:00", $user->meta->lastModified);
        $this->assertEquals("http://app.travelperk.com/api/v2/scim/Users/29", $user->meta->location);
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
        $this->travelPerk->shouldReceive('postJson')
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
            ->andReturn((object) ['data' => 'userCreated']);
        $this->assertEquals(
            (object) ['data' => 'userCreated'],
            $this->users->make(
                'testuser@test.com',
                true,
                'Test',
                'User',
            )->setHonorificPrefix('Dr')->setLocale('en')->setTitle('manager')->save()
        );
    }

    public function testCreatingAUser()
    {
        $this->travelPerk->shouldReceive('postJson')
            ->once()
            ->with('scim/Users', [
                'userName' => 'testuser@test.com',
                'name'     => [
                    'givenName'  => 'Test',
                    'familyName' => 'User',
                ],
                'active' => true,
            ])
            ->andReturn((object) ['data' => 'userCreated']);
        $this->assertEquals(
            (object) ['data' => 'userCreated'],
            $this->users->create(
                'testuser@test.com',
                true,
                'Test',
                'User',
            )
        );
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
        $this->travelPerk->shouldReceive('putJson')
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
            ->andReturn((object) ['data' => 'userReplaced']);
        $this->assertEquals(
            (object) ['data' => 'userReplaced'],
            $this->users->modify(
                $userId,
                'testuser@test.com',
                true,
                'Test',
                'User',
            )->setHonorificPrefix('Dr')->setTitle('manager')->save()
        );
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
