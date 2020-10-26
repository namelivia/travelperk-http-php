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
     * @var string
     */
    public $title;

    /**
     * @var string
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

    /* TODO: This is missing
      "urn:ietf:params:scim:schemas:extension:enterprise:2.0:User": {
        "costCenter": "Marketing",
        "manager": {
          "value": "123",
          "$ref": "https://app.travelperk.com/api/v2/scim/Users/123/",
          "displayName": "Jack Jackson"
        }
      },
      "urn:ietf:params:scim:schemas:extension:travelperk:2.0:User": {
        "gender": "M",
        "dateOfBirth": "1980-02-02",
        "travelPolicy": "Marketing travel policy",
        "invoiceProfiles": [
          {
            "value": "My Company Ltd"
          }
        ],
        "emergencyContact": {
          "name": "Jane Goodie",
          "phone": "+34 9874637"
        }
      }
     */
}
