<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\OAuth\Middleware;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Namelivia\TravelPerk\OAuth\Config\Config;
use Namelivia\TravelPerk\OAuth\Constants\Constants;

class MiddlewareFactory
{
    private $config;
    private $tokenPersistence;
    private $stack;

    public function __construct(
        Config $config,
        TokenPersistenceInterface $tokenPersistence
    ) {
        $this->tokenPersistence = $tokenPersistence;
        $this->config = $config;
        $this->stack = HandlerStack::create();
    }

    private function getOAuthMiddleware(): Middleware
    {
        $middleware = new Middleware(
            new Client(['base_uri' => Constants::TOKEN_URL]),
            $this->config->toArray()
        );
        $middleware->setTokenPersistence($this->tokenPersistence);

        return $middleware;
    }

    public function createOAuthMiddleware(): Middleware
    {
        $middleware = $this->getOAuthMiddleware();
        $this->stack->push($middleware, 'oauth');

        return $middleware;
    }

    public function recreateOAuthMiddleware(): Middleware
    {
        $this->stack->remove('oauth');
        $middleware = $this->getOAuthMiddleware();
        //Force the retrieval of an access token on creation so it gets persisted
        $middleware->getAccessToken();
        $this->stack->push($middleware, 'oauth');

        return $middleware;
    }

    public function getStack(): HandlerStack
    {
        return $this->stack;
    }
}
