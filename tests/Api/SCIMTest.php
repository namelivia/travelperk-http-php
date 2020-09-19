<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Api\SCIM;
use Namelivia\TravelPerk\Api\TravelPerk;

class SCIMTest extends TestCase
{
    private $travelPerk;
    private $scim;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->scim = new SCIM($this->travelPerk);
    }

    public function testGettingADiscoveryInstance()
    {
        $this->assertTrue($this->scim->discovery() instanceof \Namelivia\TravelPerk\SCIM\Discovery);
    }

    public function testGettingAUsersInstance()
    {
        $this->assertTrue($this->scim->users() instanceof \Namelivia\TravelPerk\SCIM\Users);
    }
}
