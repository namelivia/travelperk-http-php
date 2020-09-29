<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Client;

use GuzzleHttp\Client as GuzzleClient;

class OAuth2Client extends GuzzleClient
{
    private $apiKey;

    public function __construct(
        string $apiKey
    ) {
        return parent::__construct([
            'headers' => [
                // TODO: In the future this will seteable from the config
                'Api-Version'   => '1',
                'Authorization' => 'ApiKey '.$apiKey,
            ],
        ]);
    }
}
