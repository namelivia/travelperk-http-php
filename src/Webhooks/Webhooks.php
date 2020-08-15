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
     * List all events you can subscribe to
     */
    public function events()
    {
        return $this->travelPerk->getJson(implode('/', ['webhooks', 'events']));
    }

    /**
     * List all webhook subscriptions
     */
    public function all()
    {
        return $this->travelPerk->getJson(implode('/', ['webhooks']));
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
    public function create(string $id)
    {
        throw \RuntimeException('Not implemented yet');
    }

    /**
     * Updates the webhook endpoint
     */
    public function update(string $id)
    {
        throw \RuntimeException('Not implemented yet');
    }

    /**
     * Sends a sample payload to the webhook target URL
     */
    public function test(string $id, array $payload)
    {
        return $this->travelPerk->post(implode('/', ['webhooks', $id]), $payload);
    }

    /**
     * Deletes a webhook endpoint
     */
    public function delete(string $id)
    {
        return $this->travelPerk->delete(implode('/', ['webhooks', $id]));
    }
}
