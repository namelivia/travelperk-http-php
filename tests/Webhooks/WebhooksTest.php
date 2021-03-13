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
        $this->assertEquals('invoice.issued', $events[0]->name);
        $this->assertEquals('invoices', $events[0]->topic);
        $this->assertEquals('invoiceline.created', $events[1]->name);
        $this->assertEquals('invoices', $events[0]->topic);
    }

    public function testGettingAllWebhooks()
    {
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('webhooks')
            ->andReturn(file_get_contents('tests/stubs/webhooks.json'));
        $webhooks = $this->webhooks->all();
        $this->assertEquals(1, count($webhooks->webhooks));
        $this->assertEquals('b42820bb-24c9-48da-bded-487681e9c851', $webhooks->webhooks[0]->id);
        $this->assertEquals('invoice webhook', $webhooks->webhooks[0]->name);
        $this->assertEquals('https://mycompany/tkwebhook', $webhooks->webhooks[0]->url);
        $this->assertEquals('some secret', $webhooks->webhooks[0]->secret);
        $this->assertEquals('enabled', $webhooks->webhooks[0]->status);
        $this->assertEquals(2, count($webhooks->webhooks[0]->events));
        $this->assertEquals('invoice.issued', $webhooks->webhooks[0]->events[0]);
        $this->assertEquals('invoiceline.created', $webhooks->webhooks[0]->events[1]);
        $this->assertEquals(2, $webhooks->webhooks[0]->successfullySent);
        $this->assertEquals(0, $webhooks->webhooks[0]->failedSent);
        $this->assertEquals(0.0, $webhooks->webhooks[0]->errorRate);
    }

    public function testGettingAWebhookDetail()
    {
        $webhookId = '1a';
        $this->travelPerk->shouldReceive('get')
            ->once()
            ->with('webhooks/1a')
            ->andReturn(file_get_contents('tests/stubs/webhook.json'));
        $webhook = $this->webhooks->get($webhookId);
        $this->assertEquals('b42820bb-24c9-48da-bded-487681e9c851', $webhook->id);
        $this->assertEquals('invoice webhook', $webhook->name);
        $this->assertEquals('https://mycompany.com/tk_webhook', $webhook->url);
        $this->assertEquals('some secret', $webhook->secret);
        $this->assertEquals('enabled', $webhook->status);
        $this->assertEquals(2, count($webhook->events));
        $this->assertEquals('invoice.issued', $webhook->events[0]);
        $this->assertEquals('invoiceline.created', $webhook->events[1]);
        $this->assertEquals(2, $webhook->successfullySent);
        $this->assertEquals(0, $webhook->failedSent);
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
        $this->travelPerk->shouldReceive('post')
            ->once()
            ->with('webhooks', [
                'name'   => 'name',
                'url'    => 'url',
                'secret' => 'secret',
                'events' => ['event1', 'event2'],
            ])
            ->andReturn(file_get_contents('tests/stubs/webhook.json'));
        $newWebhook = $this->webhooks->create(
            'name',
            'url',
            'secret',
            ['event1', 'event2'],
        );
        $this->assertEquals('b42820bb-24c9-48da-bded-487681e9c851', $newWebhook->id);
        $this->assertEquals('invoice webhook', $newWebhook->name);
        $this->assertEquals('https://mycompany.com/tk_webhook', $newWebhook->url);
        $this->assertEquals('some secret', $newWebhook->secret);
        $this->assertEquals('enabled', $newWebhook->status);
        $this->assertEquals(2, count($newWebhook->events));
        $this->assertEquals('invoice.issued', $newWebhook->events[0]);
        $this->assertEquals('invoiceline.created', $newWebhook->events[1]);
        $this->assertEquals(2, $newWebhook->successfullySent);
        $this->assertEquals(0, $newWebhook->failedSent);
        $this->assertEquals(0.0, $newWebhook->errorRate);
    }

    public function testUpdatingAWebhook()
    {
        $id = '1a';
        $webhookData = Mockery::mock(UpdateWebhookInputParams::class);
        $webhookData->shouldReceive('asArray')
            ->once()
            ->with()
            ->andReturn(['params']);
        $this->travelPerk->shouldReceive('patch')
            ->once()
            ->with('webhooks/1a', ['params'])
            ->andReturn(file_get_contents('tests/stubs/webhook.json'));
        $updatedWebhook = $this->webhooks->update($id, $webhookData);
        $this->assertEquals('b42820bb-24c9-48da-bded-487681e9c851', $updatedWebhook->id);
        $this->assertEquals('invoice webhook', $updatedWebhook->name);
        $this->assertEquals('https://mycompany.com/tk_webhook', $updatedWebhook->url);
        $this->assertEquals('some secret', $updatedWebhook->secret);
        $this->assertEquals('enabled', $updatedWebhook->status);
        $this->assertEquals(2, count($updatedWebhook->events));
        $this->assertEquals('invoice.issued', $updatedWebhook->events[0]);
        $this->assertEquals('invoiceline.created', $updatedWebhook->events[1]);
        $this->assertEquals(2, $updatedWebhook->successfullySent);
        $this->assertEquals(0, $updatedWebhook->failedSent);
        $this->assertEquals(0.0, $updatedWebhook->errorRate);
    }

    public function testModifyingAWebhook()
    {
        $id = '1a';
        $this->travelPerk->shouldReceive('patch')
            ->once()
            ->with('webhooks/1a', ['name' => 'newName', 'enabled' => false])
            ->andReturn('{"data": "webhookUpdated"}');
        $this->assertEquals(
            (object) ['data' => 'webhookUpdated'],
            $this->webhooks->modify($id)->setName('newName')->setEnabled(false)->save()
        );
    }
}
