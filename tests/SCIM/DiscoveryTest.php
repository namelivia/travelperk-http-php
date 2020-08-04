<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\SCIM\Discovery;
use Namelivia\TravelPerk\Api\TravelPerk;

class DiscoveryTest extends TestCase
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
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/ServiceProviderConfig', true)
            ->andReturn('serviceProviderConfig');
        $this->assertEquals(
            'serviceProviderConfig',
            $this->discovery->serviceProviderConfig()
        );
    }

    public function testGettingResourceTypes()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/ResourceTypes', true)
            ->andReturn('resourceTypes');
        $this->assertEquals(
            'resourceTypes',
            $this->discovery->resourceTypes()
        );
    }

    public function testGettingSchemas()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Schemas', true)
            ->andReturn('schemas');
        $this->assertEquals(
            'schemas',
            $this->discovery->schemas()
        );
    }

    public function testGettingUserSchema()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:core:2.0:User', true)
            ->andReturn('userSchema');
        $this->assertEquals(
            'userSchema',
            $this->discovery->userSchema()
        );
    }

    public function testGettingEnterpriseUserSchema()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:extension:enterprise:2.0:User', true)
            ->andReturn('enterpriseUserSchema');
        $this->assertEquals(
            'enterpriseUserSchema',
            $this->discovery->enterpriseUserSchema()
        );
    }
}
