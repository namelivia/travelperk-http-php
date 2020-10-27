<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Webhooks\Webhooks;

class WebhooksAPI
{
    private $webhooks;

    public function __construct(TravelPerk $travelPerk, JsonMapper $mapper)
    {
        $this->webhooks = new Webhooks($travelPerk, $mapper);
    }

    public function webhooks(): Webhooks
    {
        return $this->webhooks;
    }
}
