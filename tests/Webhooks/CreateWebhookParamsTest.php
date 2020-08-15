<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Webhooks\CreateWebhookInputParams;

class CreateWebhookInputParamTest extends TestCase
{
    public function testSettingCreateWebhookInputParams()
    {
        $inputParams = new CreateWebhookInputParams(
            'webhook',
            'https://test.com',
            'SECRET_KEY',
            '[]'
        );
        $this->assertEquals(
            [
                'name' => 'webhook',
                'url' => 'https://test.com',
                'secret' => 'SECRET_KEY',
                'events' => '[]',
            ],
            $inputParams->asArray()
        );
    }
}
