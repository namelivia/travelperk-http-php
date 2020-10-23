<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\OAuth\Config;

class Config
{
    private $clientId;
    private $clientSecret;
    private $redirectUrl;
    private $code;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectUrl,
        string $code = null
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl = $redirectUrl;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    public function setCode(string $code): Config
    {
        $this->code = $code;

        return $this;
    }

    public function hasCode(): bool
    {
        return !is_null($this->code);
    }

    public function toArray(): array
    {
        return [
            'code'          => $this->code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUrl,
        ];
    }
}
