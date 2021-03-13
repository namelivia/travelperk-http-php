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

    private function assertEqualsCostCenterStub($costCenter): void
    {
        $this->assertEquals('1', $costCenter->id);
        $this->assertEquals('iloveorange', $costCenter->name);
        $this->assertEquals(true, $costCenter->archived);
        $this->assertEquals(1, count($costCenter->users));
        $this->assertEquals('Name', $costCenter->users[0]->firstName);
        $this->assertEquals('Lastname', $costCenter->users[0]->lastName);
        $this->assertEquals('email@email.com', $costCenter->users[0]->email);
        $this->assertEquals(1, $costCenter->users[0]->id);
        $this->assertEquals(null, $costCenter->users[0]->phone);
        $this->assertEquals(null, $costCenter->users[0]->profilePicture);
        $this->assertEquals(1, $costCenter->countUsers);
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

    public function testGettingACostCenterDetails()
    {
        $costCenterId = '1';
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('cost_centers/1')
            ->andReturn(file_get_contents('tests/stubs/cost_center.json'));
        $costCenter = $this->costCenters->get($costCenterId);
        $this->assertEqualsCostCenterStub($costCenter);
    }

    public function testModifyingACostCenter()
    {
        $id = '1a';
        $this->travelPerk->shouldReceive('patch')
            ->once()
            ->with('cost_centers/1a', ['name' => 'newName', 'archive' => false])
            ->andReturn('{"data": "costCenterUpdated"}');
        $this->assertEquals(
            (object) ['data' => 'costCenterUpdated'],
            $this->costCenters->modify($id)->setName('newName')->setArchive(false)->save()
        );
    }

    public function testBulkUpdatingCostCenters()
    {
        $this->travelPerk->shouldReceive('patch')
            ->once()
            ->with('cost_centers/bulk_update', [
                'id_list' => [1, 2, 3, 4],
                'archive' => false,
            ])
            ->andReturn(file_get_contents('tests/stubs/bulk_update.json'));
        $result = $this->costCenters->bulkUpdate()->addId(1)->addId(2)->addId(3)->addId(4)->setArchive(false)->save();
        $this->assertEquals(1, $result->updated_count);
    }

    public function testSettingUserIdsForACostCenter()
    {
        $id = '1';
        $this->travelPerk->shouldReceive('put')
            ->once()
            ->with('cost_centers/1/users', [
                'user_ids' => [1, 2, 3, 4],
            ])
            ->andReturn(file_get_contents('tests/stubs/cost_center.json'));
        $costCenter = $this->costCenters->setUsers($id)->addId(1)->addId(2)->addId(3)->addId(4)->save();
        //TODO: The mapper is missing here
        //$this->assertEqualsCostCenterStub($costCenter);
    }
}
