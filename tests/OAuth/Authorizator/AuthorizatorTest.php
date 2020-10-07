<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Namelivia\TravelPerk\OAuth\Config\Config;
use Namelivia\TravelPerk\OAuth\Authorizator\Authorizator;

class AuthorizatorTest extends TestCase
{
    private $authorizator;
    private $config;
    private $tokenPersistence;

    public function setUp(): void
    {
        parent::setUp();
        $this->config = Mockery::mock(Config::class);
        $this->tokenPersistence = Mockery::mock(TokenPersistenceInterface::class);
        $this->authorizator = new Authorizator($this->config, $this->tokenPersistence);
    }

    public function testCheckingAuthorized()
    {
        $this->tokenPersistence->shouldReceive('hasToken')
            ->once()
            ->with()
            ->andReturn(true);
        $this->assertEquals(true, $this->authorizator->isAuthorized());

        $this->tokenPersistence->shouldReceive('hasToken')
            ->once()
            ->with()
            ->andReturn(false);

        $this->config->shouldReceive('hasCode')
            ->once()
            ->with()
            ->andReturn(true);
        $this->assertEquals(true, $this->authorizator->isAuthorized());

        $this->tokenPersistence->shouldReceive('hasToken')
            ->once()
            ->with()
            ->andReturn(false);

        $this->config->shouldReceive('hasCode')
            ->once()
            ->with()
            ->andReturn(false);
        $this->assertEquals(false, $this->authorizator->isAuthorized());
    }

    public function testSettingTheAuthorizationCode()
    {
        $this->config->shouldReceive('setCode')
            ->once()
            ->with('auth-code');
        $this->assertEquals(
            $this->authorizator,
            $this->authorizator->setAuthorizationCode('auth-code')
        );
    }

    public function testGettingTheAuthUri()
    {
        $this->config->shouldReceive('getClientId')
            ->once()
            ->with()
            ->andReturn('client-id');
        $this->config->shouldReceive('getRedirectUrl')
            ->once()
            ->with()
            ->andReturn('http://redirect.url');
        $this->assertEquals(
            'https://app.travelperk.com/oauth2/authorize/?'.
            'client_id=client-id&redirect_uri=http%3A%2F%2Fredirect.url&'.
            'scope=expenses%3Aread&response_type=code&state=%2Ftarget%2Flink',
            $this->authorizator->getAuthUri('/target/link')
        );
    }
}
