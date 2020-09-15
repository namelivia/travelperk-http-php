<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use Namelivia\TravelPerk\Client\Client;

class TravelPerk
{
    const BASE_URL = 'https://api.travelperk.com/';
    const SANDBOX_BASE_URL = 'https://sandbox.travelperk.com/';
    const LEGACY_BASE_URL = 'https://app.travelperk.com/api/v2/';
    const LEGACY_SANDBOX_BASE_URL = 'https://sandbox.travelperk.com/api/v2/';

    private $legacyBaseUrl;
    private $baseUrl;
    private $client;
    private $expenses;
    private $scim;
    private $webhooks;

    public function __construct(Client $client, bool $isSandbox)
    {
        $this->client = $client;
        $this->expenses = new Expenses($this);
        $this->scim = new SCIM($this);
        $this->webhooks = new WebhooksAPI($this);
        $this->baseUrl = $isSandbox ? TravelPerk::SANDBOX_BASE_URL : TravelPerk::BASE_URL;
        $this->legacyBaseUrl = $isSandbox ? TravelPerk::LEGACY_SANDBOX_BASE_URL : TravelPerk::LEGACY_BASE_URL;
    }

    public function getAuthUri()
    {
        return $this->client->getAuthUri();
    }

    public function getJson($url, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return json_decode(
            $this->client->get(
                $baseUrl . $url
            )->getBody()->getContents()
        );
    }

    public function get($url)
    {
        return $this->client->get(
            $this->baseUrl . $url
        )->getBody()->getContents();
    }

    public function post($url, array $params, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return $this->client->post(
            $baseUrl . $url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents();
    }

    public function postJson($url, array $params, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return json_decode($this->client->post(
            $baseUrl . $url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents());
    }

    public function patch($url, array $params, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return $this->client->patch(
            $baseUrl . $url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents();
    }

    public function patchJson($url, array $params, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return json_decode($this->client->patch(
            $baseUrl . $url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents());
    }

    public function delete($url, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return $this->client->delete(
            $baseUrl . $url
        )->getBody()->getContents();
    }

    public function expenses()
    {
        return $this->expenses;
    }

    public function scim()
    {
        return $this->scim;
    }

    public function webhooks()
    {
        return $this->webhooks;
    }
}
