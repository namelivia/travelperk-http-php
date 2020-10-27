<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM\Types;

class TravelperkExtension
{
    /**
     * @var string
     */
    public $gender;

    /**
     * @var string
     */
    public $dateOfBirth;

    /**
     * @var string
     */
    public $travelPolicy;

    /**
     * @var InvoiceProfile[]
     */
    public $invoiceProfiles;

    /**
     * @var EmergencyContact
     */
    public $emergencyContact;
}
