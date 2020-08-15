<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Webhooks\Webhooks;
use Namelivia\TravelPerk\Webhooks\CreateWebhookInputParams;
use Namelivia\TravelPerk\Api\TravelPerk;

class WebhooksTest extends TestCase
{
    private $travelPerk;
    private $webhooks;

    public function setUp():void
    {
        parent::setUp();
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->webhooks = new Webhooks($this->travelPerk);
    }

    public function testGettingAllEvents()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('webhooks/events')
            ->andReturn('allEvents');
        $this->assertEquals(
            'allEvents',
            $this->webhooks->events()
        );
    }

    public function testGettingAllWebhooks()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('webhooks')
            ->andReturn('allWebhooks');
        $this->assertEquals(
            'allWebhooks',
            $this->webhooks->all()
        );
    }

    public function testGettingAWebhookDetail()
    {
        $webhookId = '1a';
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('webhooks/1a')
            ->andReturn('webhookDetails');
        $this->assertEquals(
            'webhookDetails',
            $this->webhooks->get($webhookId)
        );
    }

    public function testTestingAWebhook()
    {
        $webhookId = '1a';
        $payload = ['foo' => 'bar'];
        $this->travelPerk->shouldReceive('postJson')
            ->once()
            ->with('webhooks/1a', $payload)
            ->andReturn('webhookTestResponse');
        $this->assertEquals(
            'webhookTestResponse',
            $this->webhooks->test($webhookId, $payload)
        );
    }

    public function testDeletingAWebhook()
    {
        $webhookId = '1a';
        $this->travelPerk->shouldReceive('delete')
            ->once()
            ->with('webhooks/1a')
            ->andReturn('webhookDeleted');
        $this->assertEquals(
            'webhookDeleted',
            $this->webhooks->delete($webhookId)
        );
    }

    public function testCreatingAWebhook()
    {
        $newWebhook = Mockery::mock(CreateWebhookInputParams::class);
        $newWebhook->shouldReceive('asArray')
            ->once()
            ->with()
            ->andReturn(['params']);
        $this->travelPerk->shouldReceive('postJson')
            ->once()
            ->with('webhooks', ['params'])
            ->andReturn('webhookCreated');
        $this->assertEquals(
            'webhookCreated',
            $this->webhooks->create($newWebhook)
        );
    }
}
