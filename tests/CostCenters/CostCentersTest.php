<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\CostCenters\CostCenters;

class CostCentersTest extends TestCase
{
    private $travelPerk;
    private $costCenters;

    public function setUp(): void
    {
        parent::setUp();
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->costCenters = new CostCenters($this->travelPerk, $this->mapper);
    }

    private function assertEqualsCostCentersStub($costCentersPage): void
    {
        $this->assertEquals(0, $costCentersPage->offset);
        $this->assertEquals(10, $costCentersPage->limit);
        $this->assertEquals(1, count($costCentersPage->costCenters));
        $this->assertEquals('2', $costCentersPage->costCenters[0]->id);
        $this->assertEquals('Test Cost Center 2', $costCentersPage->costCenters[0]->name);
        $this->assertEquals('0', $costCentersPage->costCenters[0]->countUsers);
    }

    public function testGettingAllCostCenters()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('cost_centers')
            ->andReturn(file_get_contents('tests/stubs/cost_centers.json'));
        $costCenters = $this->costCenters->all();
        $this->assertEqualsCostCentersStub($costCenters);
    }
}
