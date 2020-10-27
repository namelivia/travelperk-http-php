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
     * @var int
     */
    public $totalResults;

    /**
     * @var int
     */
    public $itemsPerPage;

    /**
     * @var int
     */
    public $startIndex;

    /**
     * @var User[]
     */
    public $resources;
}
