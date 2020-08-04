<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\Users;
use Namelivia\TravelPerk\Api\TravelPerk;

class InvoiceProfilesTest extends TestCase
{
    private $travelPerk;
    private $users;

    public function setUp():void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->users = new Users($this->travelPerk);
    }

    public function testGettingServiceProviderConfig()
    {
        $this->travelPerk->shouldReceive('getJsonLegacy')
            ->once()
            ->with('scim/Users')
            ->andReturn('users');
        $this->assertEquals(
            'users',
            $this->users->all()
        );
    }
}
