<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\OAuth\Middleware\MiddlewareFactory;
use Namelivia\TravelPerk\OAuth\Middleware\Middleware;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use Namelivia\TravelPerk\OAuth\Config\Config;
use GuzzleHttp\HandlerStack;

class MiddlewareFactoryTest extends TestCase
{
    private $factory;
    private $config;
    private $tokenPersistence;

    public function setUp(): void
    {
        parent::setUp();
        $this->config = Mockery::mock(Config::class);
        $this->tokenPersistence = Mockery::mock(TokenPersistenceInterface::class);
        $this->factory = new MiddlewareFactory($this->config, $this->tokenPersistence);
    }

    public function testCreatingAnOAuthMiddleware()
    {
        $this->config->shouldReceive('toArray')
            ->once()
            ->with()
            ->andReturn([
                'client_id' => 'client_id',
                'code' => null,
            ]);
        $middleware = $this->factory->createOAuthMiddleware();
        $this->assertTrue(is_a($middleware, Middleware::class));
    }

    //TODO: Cases where there is no token or it's expired can be tested too
    public function testRecreatingAnOAuthMiddlewareRetrievingAValidTokenFromStorage()
    {
        $this->config->shouldReceive('toArray')
            ->twice()
            ->with()
            ->andReturn([
                'client_id' => 'client_id',
                'code' => null,
            ]);
        $tokenMock = Mockery::mock();
        $this->tokenPersistence->shouldReceive('restoreToken')
            ->once()
            ->with(Mockery::any())
            ->andReturn($tokenMock);
        $tokenMock->shouldReceive('isExpired')
            ->once()
            ->with()
            ->andReturn(false);
        $tokenMock->shouldReceive('getAccessToken')
            ->once()
            ->with()
            ->andReturn('accessToken');
        $oldMiddleware = $this->factory->createOAuthMiddleware();
        $newMiddleware = $this->factory->recreateOAuthMiddleware();
        $this->assertTrue(is_a($newMiddleware, Middleware::class));
        $this->assertFalse($oldMiddleware === $newMiddleware);
    }

    public function testGettingStack()
    {
        $this->assertTrue(is_a($this->factory->getStack(), HandlerStack::class));
    }
}
