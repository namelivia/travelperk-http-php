<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use GuzzleHttp\HandlerStack;
use Mockery;
use Namelivia\TravelPerk\OAuth\Authorizator\Authorizator;
use Namelivia\TravelPerk\OAuth\Client\Client;
use Namelivia\TravelPerk\OAuth\Middleware\MiddlewareFactory;
use Namelivia\TravelPerk\OAuth\MissingCodeException;

class OAuthClientTest extends TestCase
{
    private $authorizator;
    private $middlewareFactory;
    private $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->middlewareFactory = Mockery::mock(MiddlewareFactory::class);
        $this->authorizator = Mockery::mock(Authorizator::class);
        $stackMock = Mockery::mock(HandlerStack::class);
        $this->middlewareFactory->shouldReceive('getStack')
            ->once()
            ->with()
            ->andReturn($stackMock);
        $this->client = new Client(
            $this->middlewareFactory,
            $this->authorizator
        );
    }

    public function testGettingAuthUri()
    {
        $this->authorizator->shouldReceive('getAuthUri')
            ->once()
            ->with('/target/link')
            ->andReturn('auth-url');
        $this->assertEquals('auth-url', $this->client->getAuthUri('/target/link'));
    }

    public function testSettingAuthorizationCode()
    {
        $this->authorizator->shouldReceive('setAuthorizationCode')
            ->once()
            ->with('auth-code');
        $this->middlewareFactory->shouldReceive('recreateOAuthMiddleware')
            ->once()
            ->with();
        $this->assertEquals($this->client, $this->client->setAuthorizationCode('auth-code'));
    }

    public function testAuthorizationIsCheckedBeforeMakingARequest()
    {
        $this->authorizator->shouldReceive('isAuthorized')
            ->once()
            ->with()
            ->andReturn(false);
        $this->expectException(MissingCodeException::class);
        $this->expectExceptionMessage('No auth code or token');
        $this->client->get('/some/uri');

        $this->authorizator->shouldReceive('isAuthorized')
            ->once()
            ->with()
            ->andReturn(false);
        $this->expectException(MissingCodeException::class);
        $this->expectExceptionMessage('No auth code or token');
        $this->client->post('/some/uri');

        $this->authorizator->shouldReceive('isAuthorized')
            ->once()
            ->with()
            ->andReturn(false);
        $this->expectException(MissingCodeException::class);
        $this->expectExceptionMessage('No auth code or token');
        $this->client->put('/some/uri');

        $this->authorizator->shouldReceive('isAuthorized')
            ->once()
            ->with()
            ->andReturn(false);
        $this->expectException(MissingCodeException::class);
        $this->expectExceptionMessage('No auth code or token');
        $this->client->patch('/some/uri');

        $this->authorizator->shouldReceive('isAuthorized')
            ->once()
            ->with()
            ->andReturn(false);
        $this->expectException(MissingCodeException::class);
        $this->expectExceptionMessage('No auth code or token');
        $this->client->delete('/some/uri');
    }
}
