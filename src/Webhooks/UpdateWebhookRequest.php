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

    public function save()
    {
        return $this->travelPerk->patchJson(implode('/', ['webhooks', $this->id]), $this->params->asArray());
    }

    public function setName(string $name)
    {
        $this->params->setName($name);

        return $this;
    }

    public function setEnabled(bool $enabled)
    {
        $this->params->setEnabled($enabled);

        return $this;
    }

    public function setUrl(string $url)
    {
        $this->params->setUrl($url);

        return $this;
    }

    public function setSecret(string $secret)
    {
        $this->params->setSecret($secret);

        return $this;
    }

    public function setEvents(string $events)
    {
        $this->params->setEvents($events);

        return $this;
    }
}
