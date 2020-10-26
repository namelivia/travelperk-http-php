<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Webhooks\Types;

class Webhook
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $secret;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string[]
     */
    public $events;

    /**
     * @var integer
     */
    public $successfullySent;

    /**
     * @var integer
     */
    public $failedSent;

    /**
     * @var float
     */
    public $errorRate;
}
