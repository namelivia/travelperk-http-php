<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Tests;

use Namelivia\TravelPerk\Webhooks\UpdateWebhookInputParams;

class UpdateWebhookInputParamsTest extends TestCase
{
    public function testSettingUpdateWebhookInputParams()
    {
        $inputParams = new UpdateWebhookInputParams();
        $inputParams->setEnabled(false)
            ->setName('New name')
            ->setUrl('New url')
            ->setSecret('New secret')
            ->setEvents(['New event']);
        $this->assertEquals(
            [
                'name'    => 'New name',
                'enabled' => false,
                'url'     => 'New url',
                'secret'  => 'New secret',
                'events'  => ['New event'],
            ],
            $inputParams->asArray()
        );
    }
}
