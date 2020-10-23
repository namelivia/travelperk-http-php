<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Responses;

class BillingInformation
{
    /**
     * @var string
     */
    public $legalName;
    /**
     * @var string
     */
    public $vatNumber;
    /**
     * @var string
     */
    public $addressLine1;
    /**
     * @var string
     */
    public $addressLine2;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $postalCode;
    /**
     * @var string
     */
    public $countryName;
}
