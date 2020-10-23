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

    public function setName(string $name): UpdateWebhookInputParams
    {
        $this->name = $name;

        return $this;
    }

    public function setEnabled(bool $enabled): UpdateWebhookInputParams
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function setUrl(string $url): UpdateWebhookInputParams
    {
        $this->url = $url;

        return $this;
    }

    public function setSecret(string $secret): UpdateWebhookInputParams
    {
        $this->secret = $secret;

        return $this;
    }

    public function setEvents(array $events): UpdateWebhookInputParams
    {
        $this->events = $events;

        return $this;
    }

    public function asArray(): array
    {
        return array_filter([
            'name'    => $this->name,
            'url'     => $this->url,
            'secret'  => $this->secret,
            'enabled' => $this->enabled,
            'events'  => $this->events,
        ], function ($value) {return !is_null($value); });
    }
}
