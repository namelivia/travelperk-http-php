<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use JsonMapper\Enums\TextNotation;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
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
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
        $this->travelPerk = Mockery::mock(TravelPerk::class);
        $this->webhooks = new Webhooks($this->travelPerk, $this->mapper);
    }

    public function testGettingAllEvents()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('webhooks/events')
            ->andReturn(file_get_contents('tests/stubs/events.json'));
        $events = $this->webhooks->events();
        $this->assertEquals(2, count($events));
        $this->assertEquals("invoice.issued", $events[0]->name);
        $this->assertEquals("invoices", $events[0]->topic);
        $this->assertEquals("invoiceline.created", $events[1]->name);
        $this->assertEquals("invoices", $events[0]->topic);
    }

    public function testGettingAllWebhooks()
    {
        $this->travelPerk->shouldReceive('getJson')
            ->once()
            ->with('webhooks')
            ->andReturn((object) ['data' => 'allWebhooks']);
        $this->assertEquals(
            (object) ['data' => 'allWebhooks'],
            $this->webhooks->all()
        );
    }

    public function testGettingAWebhookDetail()
    {
        $webhookId = '1a';
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('webhooks/1a')
            ->andReturn(file_get_contents('tests/stubs/webhook.json'));
        $webhook = $this->webhooks->get($webhookId);
        $this->assertEquals(7, $webhook->id);
        $this->assertEquals("invoice webhook", $webhook->name);
        $this->assertEquals("https://mycompany.com/tk_webhook", $webhook->url);
        $this->assertEquals("some secret", $webhook->secret);
        $this->assertEquals("enabled", $webhook->status);
        $this->assertEquals(2, count($webhook->events));
        $this->assertEquals("invoice.issued", $webhook->events[0]);
        $this->assertEquals("invoiceline.created", $webhook->events[1]);
        $this->assertEquals(2, $webhook->successfullySent);
        $this->assertEquals(0, $webhook->faiedSent);
        $this->assertEquals(0.0, $webhook->errorRate);
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
            ->andReturn((object) ['data' => 'webhookCreated']);
        $this->assertEquals(
            (object) ['data' => 'webhookCreated'],
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
            ->andReturn((object) ['data' => 'webhookUpdated']);
        $this->assertEquals(
            (object) ['data' => 'webhookUpdated'],
            $this->webhooks->update($id, $webhookData)
        );
    }

    public function testModifyingAWebhook()
    {
        $id = '1a';
        $this->travelPerk->shouldReceive('patchJson')
            ->once()
            ->with('webhooks/1a', ['name' => 'newName', 'enabled' => false])
            ->andReturn((object) ['data' => 'webhookUpdated']);
        $this->assertEquals(
            (object) ['data' => 'webhookUpdated'],
            $this->webhooks->modify($id)->setName('newName')->setEnabled(false)->save()
        );
    }
}
