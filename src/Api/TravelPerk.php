<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use Namelivia\TravelPerk\Client\Client;

class TravelPerk
{
    private $baseUrl = 'https://api.travelperk.com/';
    private $legacyBaseUrl = 'https://app.travelperk.com/api/v2/';
    private $client;
    private $expenses;
    private $scim;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->expenses = new Expenses($this);
        $this->scim = new SCIM($this);
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

    public function patch($url, array $params, $legacy = false)
    {
        $baseUrl = $legacy ? $this->legacyBaseUrl : $this->baseUrl;
        return $this->client->patch(
            $baseUrl . $url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents();
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
}
