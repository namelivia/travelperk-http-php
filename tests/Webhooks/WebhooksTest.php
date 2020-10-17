<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Webhooks\UpdateWebhookInputParams;
use Namelivia\TravelPerk\Webhooks\Webhooks;

class WebhooksTest extends TestCase
{
    private $travelPerk;
    private $webhooks;

    public function setUp(): void
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
        $this->travelPerk->shouldReceive('post')
            ->once()
            ->with('webhooks/1a/test', [])
            ->andReturn('webhookTestResponse');
        $this->assertEquals(
            'webhookTestResponse',
            $this->webhooks->test($webhookId)
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
        $this->travelPerk->shouldReceive('postJson')
            ->once()
            ->with('webhooks', [
                'name'   => 'name',
                'url'    => 'url',
                'secret' => 'secret',
                'events' => ['event1', 'event2'],
            ])
            ->andReturn('webhookCreated');
        $this->assertEquals(
            'webhookCreated',
            $this->webhooks->create(
                'name',
                'url',
                'secret',
                ['event1', 'event2'],
            )
        );
    }

    public function testUpdatingAWebhook()
    {
        $id = '1a';
        $webhookData = Mockery::mock(UpdateWebhookInputParams::class);
        $webhookData->shouldReceive('asArray')
            ->once()
            ->with()
            ->andReturn(['params']);
        $this->travelPerk->shouldReceive('patchJson')
            ->once()
            ->with('webhooks/1a', ['params'])
            ->andReturn('webhookUpdated');
        $this->assertEquals(
            'webhookUpdated',
            $this->webhooks->update($id, $webhookData)
        );
    }

    public function testModifyingAWebhook()
    {
        $id = '1a';
        $this->travelPerk->shouldReceive('patchJson')
            ->once()
            ->with('webhooks/1a', ['name' => 'newName', 'enabled' => false])
            ->andReturn('webhookUpdated');
        $this->assertEquals(
            'webhookUpdated',
            $this->webhooks->modify($id)->setName('newName')->setEnabled(false)->save()
        );
    }
}
