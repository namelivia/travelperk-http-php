<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Api;

use GuzzleHttp\Client;
use JsonMapper\JsonMapper;

class TravelPerk
{
    const BASE_URL = 'https://api.travelperk.com/';
    const SANDBOX_BASE_URL = 'https://sandbox.travelperk.com/';

    private $baseUrl;
    private $client;
    private $expenses;
    private $scim;
    private $webhooks;
    private $travelSafe;
    private $users;
    private $trips;
    private $mapper;

    public function __construct(Client $client, bool $isSandbox, JsonMapper $mapper)
    {
        $this->client = $client;
        $this->expenses = new Expenses($this, $mapper);
        $this->scim = new SCIM($this, $mapper);
        $this->webhooks = new WebhooksAPI($this, $mapper);
        $this->travelSafe = new TravelSafeAPI($this, $mapper);
        $this->users = new UsersAPI($this, $mapper);
        $this->trips = new TripsAPI($this, $mapper);
        $this->baseUrl = $isSandbox ? TravelPerk::SANDBOX_BASE_URL : TravelPerk::BASE_URL;
    }

    public function getAuthUri(string $targetLinkUri): string
    {
        return $this->client->getAuthUri($targetLinkUri);
    }

    public function get($url): string
    {
        return $this->client->get(
            $this->baseUrl.$url
        )->getBody()->getContents();
    }

    public function post($url, array $params): string
    {
        return $this->client->post(
            $this->baseUrl.$url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents();
    }

    public function patch($url, array $params): string
    {
        return $this->client->patch(
            $this->baseUrl.$url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents();
    }

    public function put($url, array $params): string
    {
        return $this->client->put(
            $this->baseUrl.$url,
            [\GuzzleHttp\RequestOptions::JSON => $params]
        )->getBody()->getContents();
    }

    public function delete($url): string
    {
        return $this->client->delete(
            $this->baseUrl.$url
        )->getBody()->getContents();
    }

    public function setAuthorizationCode(string $authorizationCode): TravelPerk
    {
        $this->client->setAuthorizationCode($authorizationCode);

        return $this;
    }

    public function expenses(): Expenses
    {
        return $this->expenses;
    }

    public function scim(): SCIM
    {
        return $this->scim;
    }

    public function webhooks(): WebhooksAPI
    {
        return $this->webhooks;
    }

    public function travelSafe(): TravelSafeAPI
    {
        return $this->travelSafe;
    }

    public function users(): UsersAPI
    {
        return $this->users;
    }

    public function trips(): TripsAPI
    {
        return $this->trips;
    }
}
