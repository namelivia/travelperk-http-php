<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\Discovery;

class DiscoveryTest extends TestCase
{
    private $travelPerk;
    private $discovery;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->discovery = new Discovery($this->travelPerk);
    }

    public function testGettingServiceProviderConfig()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/ServiceProviderConfig')
            ->andReturn('{"data": "serviceProviderConfig"}');
        $this->assertEquals(
            (object) ['data' => 'serviceProviderConfig'],
            $this->discovery->serviceProviderConfig()
        );
    }

    public function testGettingResourceTypes()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/ResourceTypes')
            ->andReturn('{"data": "resourceTypes"}');
        $this->assertEquals(
            (object) ['data' => 'resourceTypes'],
            $this->discovery->resourceTypes()
        );
    }

    public function testGettingSchemas()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Schemas')
            ->andReturn('{"data": "schemas"}');
        $this->assertEquals(
            (object) ['data' => 'schemas'],
            $this->discovery->schemas()
        );
    }

    public function testGettingUserSchema()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:core:2.0:User')
            ->andReturn('{"data": "userSchema"}');
        $this->assertEquals(
            (object) ['data' => 'userSchema'],
            $this->discovery->userSchema()
        );
    }

    public function testGettingEnterpriseUserSchema()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:extension:enterprise:2.0:User')
            ->andReturn('{"data": "enterpriseUserSchema"}');
        $this->assertEquals(
            (object) ['data' => 'enterpriseUserSchema'],
            $this->discovery->enterpriseUserSchema()
        );
    }
}
