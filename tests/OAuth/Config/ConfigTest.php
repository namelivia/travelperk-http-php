<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\OAuth\Config\Config;

class ConfigTest extends TestCase
{
    private $config;

    public function setUp(): void
    {
        parent::setUp();
        $this->config = new Config('client-id', 'client-secret', 'http://redirect.url');
    }

    public function testGettingClientId()
    {
        $this->assertEquals('client-id', $this->config->getClientId());
    }

    public function testGettingRedirectUrl()
    {
        $this->assertEquals('http://redirect.url', $this->config->getRedirectUrl());
    }

    public function testCheckingAndSettingTheAuthCode()
    {
        $this->assertFalse($this->config->hasCode());
        $this->config->setCode('auth-code');
        $this->assertTrue($this->config->hasCode());
    }

    public function testGettingTheConfigAsAnArray()
    {
        $this->assertEquals([
            'client_id'     => 'client-id',
            'code'          => null,
            'client_secret' => 'client-secret',
            'redirect_uri'  => 'http://redirect.url',
        ], $this->config->toArray());
    }
}
