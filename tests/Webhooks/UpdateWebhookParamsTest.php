<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Mockery;
use Namelivia\TravelPerk\Webhooks\UpdateWebhookInputParams;

class UpdateWebhookInputParamTest extends TestCase
{
    public function testSettingUpdateWebhookInputParams()
    {
        $inputParams = new UpdateWebhookInputParams();
        $inputParams->setEnabled(false)
            ->setName('New name')
            ->setUrl('New url');
        $this->assertEquals(
            [
                'name' => 'New name',
                'enabled' => false,
                'url' => 'New url'
            ],
            $inputParams->asArray()
        );
    }
}
