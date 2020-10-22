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
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/ServiceProviderConfig')
            ->andReturn((object)['data' => 'serviceProviderConfig']);
        $this->assertEquals(
            (object)['data' => 'serviceProviderConfig'],
            $this->discovery->serviceProviderConfig()
        );
    }

    public function testGettingResourceTypes()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/ResourceTypes')
            ->andReturn((object)['data' => 'resourceTypes']);
        $this->assertEquals(
            (object)['data' => 'resourceTypes'],
            $this->discovery->resourceTypes()
        );
    }

    public function testGettingSchemas()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Schemas')
            ->andReturn((object)['data' => 'schemas']);
        $this->assertEquals(
            (object)['data' => 'schemas'],
            $this->discovery->schemas()
        );
    }

    public function testGettingUserSchema()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:core:2.0:User')
            ->andReturn((object)['data' => 'userSchema']);
        $this->assertEquals(
            (object)['data' => 'userSchema'],
            $this->discovery->userSchema()
        );
    }

    public function testGettingEnterpriseUserSchema()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('scim/Schemas/urn:ietf:params:scim:schemas:extension:enterprise:2.0:User')
            ->andReturn((object)['data' => 'enterpriseUserSchema']);
        $this->assertEquals(
            (object)['data' => 'enterpriseUserSchema'],
            $this->discovery->enterpriseUserSchema()
        );
    }
}
