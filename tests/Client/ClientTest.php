<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\Client\Client;
use Namelivia\TravelPerk\Exceptions\NotImplementedException;

class ClientTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client('some-api-key');
    }

    public function testAuthorizationCodeCantBeSet()
    {
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage('No authorization code needed for simple api key authentication');
        $this->client->setAuthorizationCode('authorization-code');
    }

    public function testAuthUriCantBeQueried()
    {
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage('No authorization URI for simple api key authentication');
        $this->client->getAuthUri('/target/link');
    }
}
