<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

class CreateWebhookInputParams
{
    private $name;
    private $url;
    private $secret;
    private $events;

    public function __construct(string $name, string $url, string $secret, string $events)
    {
        $this->name = $name;
        $this->url = $url;
        $this->secret = $secret;
        $this->events = $events;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setUrl(string $Url)
    {
        $this->name = $name;
        return $this;
    }

    public function setSecret(string $secret)
    {
        $this->secret = $secret;
        return $this;
    }

    public function setEvents(string $events)
    {
        $this->events = $events;
        return $this;
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
