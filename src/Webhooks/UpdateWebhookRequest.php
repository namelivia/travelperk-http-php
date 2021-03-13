<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

use Namelivia\TravelPerk\Api\TravelPerk;

class UpdateWebhookRequest
{
    private $params;
    private $travelPerk;
    private $id;

    public function __construct(string $id, TravelPerk $travelPerk)
    {
        $this->id = $id;
        $this->params = new UpdateWebhookInputParams();
        $this->travelPerk = $travelPerk;
    }

    public function save(): object
    {
        return json_decode($this->travelPerk->patch(implode('/', ['webhooks', $this->id]), $this->params->asArray()));
    }

    public function setName(string $name): UpdateWebhookRequest
    {
        $this->params->setName($name);

        return $this;
    }

    public function setEnabled(bool $enabled): UpdateWebhookRequest
    {
        $this->params->setEnabled($enabled);

        return $this;
    }

    public function setUrl(string $url): UpdateWebhookRequest
    {
        $this->params->setUrl($url);

        return $this;
    }

    public function setSecret(string $secret): UpdateWebhookRequest
    {
        $this->params->setSecret($secret);

        return $this;
    }

    public function setEvents(array $events): UpdateWebhookRequest
    {
        $this->params->setEvents($events);

        return $this;
    }
}
