<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\Discovery;
use Namelivia\TravelPerk\Api\TravelPerk;

class InvoiceProfilesTest extends TestCase
{
    private $travelPerk;
    private $discovery;

    public function setUp():void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->discovery = new Discovery($this->travelPerk);
    }

    public function testGettingServiceProviderConfig()
    {
        $this->travelPerk->shouldReceive('getJsonLegacy')
            ->once()
            ->with('scim/ServiceProviderConfig')
            ->andReturn('serviceProviderConfig');
        $this->assertEquals(
            'serviceProviderConfig',
            $this->discovery->serviceProviderConfig()
        );
    }
}
