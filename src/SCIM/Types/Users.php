<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM\Types;

class Users
{
    /**
     * @var string[]
     */
    public $schemas;

    /**
     * @var integer
     */
    public $totalResults;

    /**
     * @var integer
     */
    public $itemsPerPage;

    /**
     * @var integer
     */
    public $startIndex;

    /**
     * @var User[]
     */
    public $resources;
}
