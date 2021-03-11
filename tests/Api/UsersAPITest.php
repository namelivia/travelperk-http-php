<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\JsonMapper;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Api\UsersAPI;

class UsersAPITest extends TestCase
{
    private $travelPerk;
    private $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->users = new UsersAPI($this->travelPerk, Mockery::mock(JsonMapper::class));
    }

    public function testGettingAUsersInstance()
    {
        $this->assertTrue($this->users->users() instanceof \Namelivia\TravelPerk\Users\Users);
    }
}
