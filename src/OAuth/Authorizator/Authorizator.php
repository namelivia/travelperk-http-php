<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\OAuth\Authorizator;

use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Namelivia\TravelPerk\OAuth\Config\Config;
use Namelivia\TravelPerk\OAuth\Constants\Constants;

class Authorizator
{
    public function __construct(
        Config $config,
        TokenPersistenceInterface $tokenPersistence,
        array $scopes
    ) {
        $this->config = $config;
        $this->tokenPersistence = $tokenPersistence;
        $this->scopes = new Scopes($scopes);
    }

    public function getAuthUri(string $targetLinkUri)
    {
        return Constants::AUTHORIZE_URL.'?'.http_build_query([
            'client_id'    => $this->config->getClientId(),
            'redirect_uri' => $this->config->getRedirectUrl(),
            'scope'        => $this->scopes->asUrlParam(),
            'response_type' => 'code',
            //TODO: This should be more sofisticate to avoid vulnerabilities. https://github.com/namelivia/travelperk-http-php/issues/21
            //base64 encoded info could be sent to have url, method and also a nonce.
            //More info here: https://tools.ietf.org/id/draft-bradley-oauth-jwt-encoded-state-08.html
            'state' => $targetLinkUri,
        ]);
    }

    public function setAuthorizationCode(string $code)
    {
        $this->config->setCode($code);

        return $this;
    }

    public function isAuthorized()
    {
        return $this->tokenPersistence->hasToken() || $this->config->hasCode();
    }
}
