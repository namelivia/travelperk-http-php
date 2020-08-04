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

    public function testGettingResourceTypes()
    {
        $this->travelPerk->shouldReceive('getJsonLegacy')
            ->once()
            ->with('scim/ResourceTypes')
            ->andReturn('resourceTypes');
        $this->assertEquals(
            'resourceTypes',
            $this->discovery->resourceTypes()
        );
    }

    public function testGettingSchemas()
    {
        $this->travelPerk->shouldReceive('getJsonLegacy')
            ->once()
            ->with('scim/Schemas')
            ->andReturn('schemas');
        $this->assertEquals(
            'schemas',
            $this->discovery->schemas()
        );
    }

    public function testGettingUserSchema()
    {
        $this->travelPerk->shouldReceive('getJsonLegacy')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:core:2.0:User')
            ->andReturn('userSchema');
        $this->assertEquals(
            'userSchema',
            $this->discovery->userSchema()
        );
    }

    public function testGettingEnterpriseUserSchema()
    {
        $this->travelPerk->shouldReceive('getJsonLegacy')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:extension:enterprise:2.0:User')
            ->andReturn('enterpriseUserSchema');
        $this->assertEquals(
            'enterpriseUserSchema',
            $this->discovery->enterpriseUserSchema()
        );
    }
}
