<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk;

use Namelivia\TravelPerk\Client\Client;

class ServiceProvider
{
    public function build(
        string $apiKey,
        bool $isSandbox
    ) {
        $client = new Client($apiKey);

        return new \Namelivia\TravelPerk\Api\TravelPerk($client, $isSandbox);
    }
}
