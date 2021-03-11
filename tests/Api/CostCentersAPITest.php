<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\JsonMapper;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Api\CostCentersAPI;

class CostCentersAPITest extends TestCase
{
    private $travelPerk;
    private $costCenters;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->costCenters = new CostCentersAPI($this->travelPerk, Mockery::mock(JsonMapper::class));
    }

    public function testGettingACostCentersInstance()
    {
        $this->assertTrue($this->costCenters->costCenters() instanceof \Namelivia\TravelPerk\CostCenters\CostCenters);
    }
}
