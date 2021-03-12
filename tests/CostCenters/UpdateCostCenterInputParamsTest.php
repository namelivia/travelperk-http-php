<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\CostCenters\UpdateCostCenterInputParams;

class UpdateCostCenterInputParamTest extends TestCase
{
    public function testSettingUpdateCostCenterInputParamsNoName()
    {
        $inputParams = new UpdateCostCenterInputParams();
        $inputParams->setArchive(false);
        $this->assertEquals(
            [
                'archive'   => false,
            ],
            $inputParams->asArray()
        );
    }

    public function testSettingUpdateCostCenterInputParamsName()
    {
        $inputParams = new UpdateCostCenterInputParams();
        $inputParams->setArchive(true)->setName('test name');
        $this->assertEquals(
            [
                'name'    => 'test name',
                'archive' => true,
            ],
            $inputParams->asArray()
        );
    }
}
