<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\Types\Event;
use Namelivia\TravelPerk\SCIM\Types\Webhook;

class Webhooks
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk,  JsonMapper $mapper)
    {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class)
    {
        $result = new $class();
        $response = $this->travelPerk->{$method}($url);
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
    public function all(): object
    {
        return $this->travelPerk->getJson(implode('/', ['webhooks']));
    }

    /**
     * Get details for a specific webhook endpoint.
     */
    public function get(string $id): object
    {
        return $this->execute('get', implode('/', ['webhooks', $id]), Webhook::class);
    }

    /**
     * Create a webhook endpoint.
     */
    public function create(string $name, string $url, string $secret, array $events): object
    {
        $params = new CreateWebhookInputParams($name, $url, $secret, $events);

        return $this->travelPerk->postJson(implode('/', ['webhooks']), $params->asArray());
    }

    /**
     * Updates the webhook endpoint. (Will be removed, use modify instead).
     */
    public function update(string $id, UpdateWebhookInputParams $params): object
    {
        return $this->travelPerk->patchJson(implode('/', ['webhooks', $id]), $params->asArray());
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
