<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\Users;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\UsersInputParams;
use Namelivia\TravelPerk\SCIM\CreateUserInputParams;

class UsersTest extends TestCase
{
    private $travelPerk;
    private $users;

    public function setUp():void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->users = new Users($this->travelPerk);
    }

    public function testGettingAllUsersNoParams()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users', true)
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
            ->with('scim/Users?count=5&start_index=3', true)
            ->andReturn('allUsers');
        $params = (new UsersInputParams())
            ->setCount(5)
            ->setStartIndex(3);
        $this->assertEquals(
            'allUsers',
            $this->users->all($params)
        );
    }

    public function testGettingAUserDetail()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Users/1', true)
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
            ->with('scim/Users/1', true)
            ->andReturn('userDeleted');
        $this->assertEquals(
            'userDeleted',
            $this->users->delete(1)
        );
    }

    public function testCreatingAUser()
    {
        $newUser = Mockery::mock(CreateUserInputParams::class);
        $newUser->shouldReceive('asArray')
            ->once()
            ->with()
            ->andReturn(['params']);
        $this->travelPerk->shouldReceive('post')
            ->once()
            ->with('scim/Users/', ['params'], true)
            ->andReturn('userCreated');
        $this->assertEquals(
            'userCreated',
            $this->users->create($newUser)
        );
    }
}
