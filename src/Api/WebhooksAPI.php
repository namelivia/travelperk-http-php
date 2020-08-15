<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use Namelivia\TravelPerk\Webhooks\Webhooks;

class WebhooksAPI
{
    private $webhooks;

    public function __construct(TravelPerk $travelPerk)
    {
        $this->webhooks = new Webhooks($travelPerk);
    }

    public function webhooks()
    {
        return $this->webhooks;
    }
}
