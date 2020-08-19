<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Webhooks\CreateWebhooksInputParams;
use Namelivia\TravelPerk\Webhooks\UpdateWebhooksInputParams;
use Namelivia\TravelPerk\Webhooks\WebhooksInputParams;

class Webhooks
{
    private $travelPerk;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->travelPerk = $travelPerk;
    }

    /**
     * List all events you can subscribe to
     */
    public function events()
    {
        return $this->travelPerk->getJson(implode('/', ['webhooks', 'events']));
    }

    /**
     * List all webhook subscriptions
     */
    public function all(WebhooksInputParams $params = null)
    {
        $params = isset($params) ? '?' . $params->asUrlParam() : null;
        return $this->travelPerk->getJson(implode('/', ['webhooks']) . $params);
    }

    /**
     * Get details for a specific webhook endpoint
     */
    public function get(string $id)
    {
        return $this->travelPerk->getJson(implode('/', ['webhooks', $id]));
    }

    /**
     * Create a webhook endpoint
     */
    public function create(CreateWebhookInputParams $params)
    {
        return $this->travelPerk->postJson(implode('/', ['webhooks']), $params->asArray());
    }

    /**
     * Updates the webhook endpoint
     */
    public function update(string $id, UpdateWebhookInputParams $params)
    {
        return $this->travelPerk->patchJson(implode('/', ['webhooks', $id]), $params->asArray());
    }

    /**
     * Sends a sample payload to the webhook target URL
     */
    public function test(string $id, array $payload)
    {
        return $this->travelPerk->postJson(implode('/', ['webhooks', $id, 'test']), $payload);
    }

    /**
     * Deletes a webhook endpoint
     */
    public function delete(string $id)
    {
        return $this->travelPerk->delete(implode('/', ['webhooks', $id]));
    }
}
