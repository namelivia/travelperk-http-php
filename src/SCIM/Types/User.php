<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM\Types;

class User
{
    /**
     * @var string[]
     */
    public $schemas;

    /**
     * @var Name
     */
    public $name;

    /**
     * @var string
     */
    public $locale;

    /**
     * @var string
     */
    public $preferredLanguage;

    /**
     * @var string|null
     */
    public $title;

    /**
     * @var string|null
     */
    public $externalId;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string[]
     */
    public $groups;

    /**
     * @var string
     */
    public $active;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var PhoneNumber[]
     */
    public $phoneNumbers;

    /**
     * @var Meta
     */
    public $meta;

    /**
     * @var EnterpriseExtension
     */
    public $enterpriseExtension;

    /**
     * @var TravelperkExtension
     */
    public $travelperkExtension;
}
