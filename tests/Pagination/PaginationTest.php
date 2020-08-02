<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Pagination\Pagination;

class PaginationTest extends TestCase
{
    public function testSettingPaginationParams()
    {
        $this->assertEquals(
            'offset=10&limit=20',
            (new Pagination(10, 20))->asUrlParam()
        );
    }
}
