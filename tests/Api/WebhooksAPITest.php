<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Api\WebhooksAPI;
use Namelivia\TravelPerk\Api\TravelPerk;

class WebhooksAPITest extends TestCase
{
    private $travelPerk;
    private $webhooks;

    public function setUp():void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->webhooks = new WebhooksAPI($this->travelPerk);
    }

    public function testGettingAWebhooksInstance()
    {
        $this->assertTrue($this->webhooks->webhooks() instanceof \Namelivia\TravelPerk\Webhooks\Webhooks);
    }
}
