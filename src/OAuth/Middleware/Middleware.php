<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\OAuth\Middleware;

use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\AuthorizationCode;
use kamermans\OAuth2\GrantType\RefreshToken;
use kamermans\OAuth2\OAuth2Middleware;

class Middleware extends OAuth2Middleware
{
    public function __construct(
        Client $reauthClient,
        array $config
    ) {
        return parent::__construct(
            new AuthorizationCode($reauthClient, $config),
            new RefreshToken($reauthClient, $config)
        );
    }

    public function setTokenPersistence($tokenPersistence)
    {
        return parent::setTokenPersistence($tokenPersistence);
    }
}
