<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM\Types;

class TravelperkExtension
{
    /**
     * @var string|null
     */
    public $gender;

    /**
     * @var string|null
     */
    public $dateOfBirth;

    /**
     * @var string|null
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
