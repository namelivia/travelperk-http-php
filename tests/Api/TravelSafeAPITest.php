<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\JsonMapper;
use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Api\TravelSafeAPI;

class TravelSafeAPITest extends TestCase
{
    private $travelPerk;
    private $webhooks;

    public function setUp(): void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->travelSafe = new TravelSafeAPI($this->travelPerk, Mockery::mock(JsonMapper::class));
    }

    public function testGettingATravelSafeInstance()
    {
        $this->assertTrue($this->travelSafe->travelSafe() instanceof \Namelivia\TravelPerk\TravelSafe\TravelSafe);
    }
}
