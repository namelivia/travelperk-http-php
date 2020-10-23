<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

use Namelivia\TravelPerk\Api\TravelPerk;

class Webhooks
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * List all events you can subscribe to.
     */
    public function events(): object
    {
        return $this->travelPerk->getJson(implode('/', ['webhooks', 'events']));
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
        return $this->travelPerk->getJson(implode('/', ['webhooks', $id]));
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
