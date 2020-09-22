<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

class CreateWebhookInputParams
{
    private $params;

    public function __construct(string $name, string $url, string $secret, array $events)
    {
        $this->params = (new UpdateWebhookInputParams())
            ->setName($name)
            ->setUrl($url)
            ->setSecret($secret)
            ->setEvents($events);
    }

    public function asArray()
    {
        return $this->params->asArray();
    }
}
