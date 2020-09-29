<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\ServiceProvider;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
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

    public function testServiceProviderOAuth()
    {
        //$this->markTestSkipped('Badly written test');
        $clientId = 'clientId';
        $secretKey = 'secretKey';
        $redirectUrl = 'https://redirect.url';
        $tokenPersistence = Mockery::mock(TokenPersistenceInterface::class);
        $travelPerk = (new ServiceProvider())->buildOAuth2($clientId, $secretKey, $redirectUrl, $tokenPersistence, false);
        var_dump($travelPerk->expenses()->invoiceProfiles()->all());
    }
}
