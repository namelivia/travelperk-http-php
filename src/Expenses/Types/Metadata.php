<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class Metadata
{
    /**
     * @var int|null
     */
    public $tripId;

    /**
     * @var string|null
     */
    public $tripName;

    /**
     * @var string
     */
    public $service;

    /**
     * @var User[]
     */
    public $travelers;

    /**
     * @var string|null
     */
    public $startDate;

    /**
     * @var string|null
     */
    public $endDate;

    /**
     * @var string|null
     */
    public $costCenter;

    /**
    * @var string[]
    */
    public $labels;

    /**
     * @var Vendor|null
     */
    public $vendor;

    /**
     * @var bool|null
     */
    public $outOfPolicy;

    /**
     * @var User[]
     */
    public $approvers;

    /**
     * @var User|null
     */
    public $booker;
}
