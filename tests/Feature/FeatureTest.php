<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\ServiceProvider;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\TokenInterface;
use Mockery;

class FeatureTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    // TODO: This test is actually making an HTTP request
    // TODO: So as the api key is not a real one, this is failing.
    public function testServiceProvider()
    {
        //$this->markTestSkipped('Badly written test');
        $apiKey = 'apiKey';
        $travelPerk = (new ServiceProvider())->build($apiKey, false);
        var_dump($travelPerk->expenses()->invoiceProfiles()->all());
    }

    public function testNoTokenOrCode()
    {
		//As there is no token and no code,
		//an exception will be thrown asking to set the code first.
		$tokenPersistence = Mockery::mock(TokenPersistenceInterface::class);
		//No auth token persisted yet
		$tokenPersistence->shouldReceive('hasToken')
			->once()
			->with()
			->andReturn(false);
		$clientId = 'clientId';
		$clientSecret = 'clientSecret';
		$redirectUrl = 'redirectUrl';
		$travelPerk = (new ServiceProvider())->buildOAuth2($tokenPersistence, $clientId, $clientSecret, $redirectUrl, false);
		$this->expectException(\Namelivia\TravelPerk\OAuth\MissingCodeException::class);
        $travelPerk->expenses()->invoiceProfiles()->all();
    }

	//TODO: This test is actually making an HTTP request. And fails as the access token is just a mock.
    public function testTokenIsPersisted()
    {
		$tokenPersistence = Mockery::mock(TokenPersistenceInterface::class);
		//The auth token is already persisted
		$tokenPersistence->shouldReceive('hasToken')
			->once()
			->with()
			->andReturn(true);
		//TODO: Review this code on kamermans repo to see what is this doing and what params does it have
		//TODO: Also I'm not sure why is it making so many calls
		$tokenMock = Mockery::mock(TokenInterface::class);
		$tokenPersistence->shouldReceive('restoreToken')
			->times(2)
			->andReturn($tokenMock);
		$tokenMock->shouldReceive('isExpired')
			->times(3)
			->with()
			->andReturn(false);
		$tokenMock->shouldReceive('getAccessToken')
			->times(3)
			->with()
			->andReturn('SomeAccessToken');
		$tokenPersistence->shouldReceive('deleteToken')
			->once()
			->with();
		$clientId = 'clientId';
		$clientSecret = 'clientSecret';
		$redirectUrl = 'redirectUrl';
		$travelPerk = (new ServiceProvider())->buildOAuth2($tokenPersistence, $clientId, $clientSecret, $redirectUrl, false);
		$this->expectException(\GuzzleHttp\Exception\ClientException::class);
        $travelPerk->expenses()->invoiceProfiles()->all();
    }

	//TODO: This test is actually making an HTTP request
	//TODO: So as the code is not set yet and the stack re-created, this is failing.
    public function testCodeIsSet()
    {
		$tokenPersistence = Mockery::mock(TokenPersistenceInterface::class);
		//No auth token persisted yet
		$tokenPersistence->shouldReceive('hasToken')
			->once()
			->with()
			->andReturn(false);
		//TODO: Review this code on kamermans repo to see what is this doing and what params does it have
		//TODO: I'm not actually sure what's going on under the hood
		$tokenPersistence->shouldReceive('restoreToken')
			->once()
			->andReturn(null);
		$tokenPersistence->shouldReceive('deleteToken')
			->once();
		$clientId = 'clientId';
		$clientSecret = 'clientSecret';
		$redirectUrl = 'redirectUrl';
		$travelPerk = (new ServiceProvider())->buildOAuth2($tokenPersistence, $clientId, $clientSecret, $redirectUrl, false);
		//Authorization code is set
		$travelPerk->setAuthorizationCode('AuthorizationCode');
		$this->expectException(\kamermans\OAuth2\Exception\AccessTokenRequestException::class);
        $travelPerk->expenses()->invoiceProfiles()->all();
    }
}
