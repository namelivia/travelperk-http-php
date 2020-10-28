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
     * @var boolean
     */
    public $enabled;

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
     * @var int
     */
    public $successfullySent;

    /**
     * @var int
     */
    public $failedSent;

    /**
     * @var float
     */
    public $errorRate;
}
