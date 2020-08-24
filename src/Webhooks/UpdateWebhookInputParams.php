<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks;

class UpdateWebhookInputParams
{
    private $name;
    private $url;
    private $secret;
    private $enabled;
    private $events;

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function setSecret(string $secret)
    {
        $this->secret = $secret;
        return $this;
    }

    public function setEvents(array $events)
    {
        $this->events = $events;
        return $this;
    }

    public function asArray()
    {
        return array_filter([
            'name' => $this->name,
            'url' => $this->url,
            'secret' => $this->secret,
            'enabled' => $this->enabled,
            'events' => $this->events,
        ], function($value) {return !is_null($value);});
    }
}
