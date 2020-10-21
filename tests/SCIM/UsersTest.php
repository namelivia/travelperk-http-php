<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

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
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->users = new Users($this->travelPerk);
    }

    public function testGettingAllUsersNoParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users')
            ->andReturn('allUsers');
        $this->assertEquals(
            'allUsers',
            $this->users->all()
        );
    }

    public function testGettingAllUsersWithParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users?count=5&startIndex=3')
            ->andReturn('allUsers');
        $params = (new UsersInputParams())
            ->setCount(5)
            ->setStartIndex(3);
        $this->assertEquals(
            'allUsers',
            $this->users->all($params)
        );
    }

    public function testGettingAllUsersWithParamsUsingQuery()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users?count=5&startIndex=3')
            ->andReturn('allUsers');
        $this->assertEquals(
            'allUsers',
            $this->users->query()
            ->setCount(5)
            ->setStartIndex(3)
            ->get()
        );
    }

    public function testGettingAUserDetail()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users/1')
            ->andReturn('userDetail');
        $this->assertEquals(
            'userDetail',
            $this->users->get(1)
        );
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
            ->andReturn('userCreated');
        $this->assertEquals(
            'userCreated',
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
            ->andReturn('userCreated');
        $this->assertEquals(
            'userCreated',
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
            ->andReturn('userReplaced');
        $this->assertEquals(
            'userReplaced',
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
