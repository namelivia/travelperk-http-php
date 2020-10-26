<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Webhooks\Types\Event;
use Namelivia\TravelPerk\Webhooks\Types\Webhook;
use Namelivia\TravelPerk\Webhooks\Types\Webhooks as WebhooksType;

class Webhooks
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk,  JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class, array $params = null)
    {
        $result = new $class();
        if (is_null($params)) {
            $response = $this->travelPerk->{$method}($url);
        } else {
            $response = $this->travelPerk->{$method}($url, $params);
        }
        $this->mapper->mapObject(
            json_decode($response),
            $result
        );

        return $result;
    }

    /**
     * List all events you can subscribe to.
     */
    public function events(): array
    {
        $events = $this->travelPerk->get(implode('/', ['webhooks', 'events']));
        return array_map(function($event) {
            $eventInstance = new Event();
            $this->mapper->mapObject(
                $event,
                $eventInstance
            );
            return $eventInstance;
        }, json_decode($events));
    }

    /**
     * List all webhook subscriptions.
     */
    public function all(): WebhooksType
    {
        return $this->execute('get', implode('/', ['webhooks']), WebhooksType::class);
    }

    /**
     * Get details for a specific webhook endpoint.
     */
    public function get(string $id): Webhook
    {
        return $this->execute('get', implode('/', ['webhooks', $id]), Webhook::class);
    }

    /**
     * Create a webhook endpoint.
     */
    public function create(string $name, string $url, string $secret, array $events): Webhook
    {
        $params = new CreateWebhookInputParams($name, $url, $secret, $events);

        return $this->execute('post', implode('/', ['webhooks']), Webhook::class, $params->asArray());
    }

    /**
     * Updates the webhook endpoint. (Will be removed, use modify instead).
     */
    public function update(string $id, UpdateWebhookInputParams $params): Webhook
    {
        return $this->execute('patch', implode('/', ['webhooks', $id]), Webhook::class, $params->asArray());
    }

    /**
     * Update the webhook endpoint.
     */
    public function modify(string $id): UpdateWebhookRequest
    {
        return new UpdateWebhookRequest($id, $this->travelPerk);
    }

    /**
     * Performs a webhook test call.
     */
    public function test(string $id): string
    {
        return $this->travelPerk->post(implode('/', ['webhooks', $id, 'test']), []);
    }

    /**
     * Deletes a webhook endpoint.
     */
    public function delete(string $id): string
    {
        return $this->travelPerk->delete(implode('/', ['webhooks', $id]));
    }
}
