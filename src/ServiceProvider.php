<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk;

use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\Client\Client;
use Namelivia\TravelPerk\OAuth\Authorizator\Authorizator;
use Namelivia\TravelPerk\OAuth\Client\Client as OAuth2Client;
use Namelivia\TravelPerk\OAuth\Config\Config;
use Namelivia\TravelPerk\OAuth\Middleware\MiddlewareFactory;
use JsonMapper\JsonMapperFactory;
use JsonMapper\Middleware\CaseConversion;
use JsonMapper\Enums\TextNotation;

class ServiceProvider
{
	private $mapper;

	public function __construct()
	{
        $this->mapper = (new JsonMapperFactory())->default();
        $this->mapper->push(new CaseConversion(TextNotation::UNDERSCORE(), TextNotation::CAMEL_CASE()));
	}

    public function buildOAuth2(
        TokenPersistenceInterface $tokenPersistence,
        string $clientId,
        string $clientSecret,
        string $redirectUrl,
        array $scopes,
        bool $isSandbox
    ): TravelPerk {
        $config = new Config($clientId, $clientSecret, $redirectUrl);
        $authorizator = new Authorizator($config, $tokenPersistence, $scopes);
        $middlewareFactory = new MiddlewareFactory($config, $tokenPersistence);
        $middlewareFactory->createOAuthMiddleware();
        $client = new OAuth2Client($middlewareFactory, $authorizator);

        return new TravelPerk($client, $isSandbox, $this->mapper);
    }

    public function build(
        string $apiKey,
        bool $isSandbox
    ): TravelPerk {
        $client = new Client($apiKey);

        return new TravelPerk($client, $isSandbox, $this->mapper);
    }
}
