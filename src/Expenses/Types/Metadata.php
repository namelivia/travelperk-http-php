<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class Metadata
{

    /**
     * @var integer
     */
    public $tripId;

    /**
     * @var string
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
     * @var string
     */
    public $startDate;

    /**
     * @var string
     */
    public $endDate;

    /**
     * @var string
     */
    public $costCenter;

    /**
     * @var string[]
     */
    public $labels;

    /**
     * @var Vendor
     */
    public $vendor;

    /**
     * @var boolean
     */
    public $outOfPolicy;

    /**
     * @var User[]
     */
    public $approvers;

    /**
     * @var User
     */
    public $booker;

}
