<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk;

use Namelivia\TravelPerk\Client\Client;
use Namelivia\TravelPerk\OAuth\Factory\Factory;
use Namelivia\TravelPerk\OAuth\Config\Config;
use Namelivia\TravelPerk\OAuth\Authorizator\Authorizator;
use Namelivia\TravelPerk\OAuth\Middleware\MiddlewareFactory;
use Namelivia\TravelPerk\OAuth\Client\Client as OAuth2Client;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;

class ServiceProvider
{
	public function buildOAuth2(
        string $clientId,
        string $clientSecret,
        string $redirectUrl,
        TokenPersistenceInterface $tokenPersistence,
        bool $isSandbox
	) {
		$config = new Config($clientId, $clientSecret, $redirectUrl);
		$authorizator = new Authorizator($config, $tokenPersistence);
		$middlewareFactory = new MiddlewareFactory($config, $tokenPersistence);
		$middlewareFactory->createOAuthMiddleware();
		$client = new OAuth2Client($middlewareFactory, $authorizator);
        return new \Namelivia\TravelPerk\Api\TravelPerk($client, $isSandbox);
	}
    public function build(
        string $apiKey,
        bool $isSandbox
    ) {
        $client = new Client($apiKey);

        return new \Namelivia\TravelPerk\Api\TravelPerk($client, $isSandbox);
    }
}
