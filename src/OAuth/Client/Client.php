<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\OAuth\Client;

use GuzzleHttp\Client as OAuthClient;
use Namelivia\TravelPerk\OAuth\Authorizator\Authorizator;
use GuzzleHttp\HandlerStack;
use Namelivia\TravelPerk\OAuth\MissingCodeException;
use Namelivia\TravelPerk\OAuth\Middleware\MiddlewareFactory;
use Psr\Http\Message\ResponseInterface;

class Client extends OAuthClient
{
    private $authorizator;
    private $middlewareFactory;

    public function __construct(
        MiddlewareFactory $middlewareFactory,
        Authorizator $authorizator
    ) {
        $this->middlewareFactory = $middlewareFactory;
        $this->authorizator = $authorizator;
        return parent::__construct([
            'handler' => $this->middlewareFactory->getStack(),
            'auth' => 'oauth',
        ]);
    }

    //TODO:Here I can retrieve the auth from the authorizator
    public function getAuthUri()
    {
        return $this->authorizator->getAuthUri();
    }

    //TODO:Here I can check if I'm authorized or not
    private function checkAuthorized()
    {
        if (!$this->authorizator->isAuthorized()) {
            throw new MissingCodeException('No auth code or token');
        }
    }

    //TODO:Here I set the code and replace the middleware
    public function setAuthorizationCode(string $code)
    {
        $this->authorizator->setAuthorizationCode($code);
        $this->middlewareFactory->recreateOAuthMiddleware();
    }

    //Before each method I will check if I am authorized
    public function get($uri, array $options = []): ResponseInterface
    {
        $this->checkAuthorized();
        return parent::get($uri, $options);
    }

    public function post($uri, array $options = []): ResponseInterface
    {
        $this->checkAuthorized();
        return parent::post($uri, $options);
    }

    public function put($uri, array $options = []): ResponseInterface
    {
        $this->checkAuthorized();
        return parent::put($uri, $options);
    }

    public function patch($uri, array $options = []): ResponseInterface
    {
        $this->checkAuthorized();
        return parent::patch($uri, $options);
    }

    public function delete($uri, array $options = []): ResponseInterface
    {
        $this->checkAuthorized();
        return parent::delete($uri, $options);
    }
}
