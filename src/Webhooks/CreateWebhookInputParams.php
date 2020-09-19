<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

class CreateWebhookInputParams
{
    private $name;
    private $url;
    private $secret;
    private $events;

    public function __construct(string $name, string $url, string $secret, array $events)
    {
        $this->name = $name;
        $this->url = $url;
        $this->secret = $secret;
        $this->events = $events;
    }

    public function asArray()
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'secret' => $this->secret,
            'events' => $this->events,
        ];
    }
}
