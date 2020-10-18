<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;

class CreateUserQuery
{
    private $params;
    private $travelPerk;

    public function __construct(
        TravelPerk $travelPerk,
        string $username,
        bool $active,
        NameInputParams $name
    ) {
        $this->travelPerk = $travelPerk;
        $this->params = new CreateUserInputParams($username, $active, $name);
    }

    public function save()
    {
        return $this->travelPerk->postJson(implode('/', ['scim', 'Users']), $this->params->asArray());
    }

    public function setLanguage(Language $language)
    {
        $this->params->setLanguage($language);

        return $this;
    }

    public function setLocale(string $locale)
    {
        $this->params->setLocale($locale);

        return $this;
    }

    public function setTitle(string $title)
    {
        $this->params->setTitle($title);

        return $this;
    }

    public function setExternalId(string $externalId)
    {
        $this->params->setExternalId($externalId);

        return $this;
    }

    public function setPhoneNumber(string $number)
    {
        $this->params->setPhoneNumber($number);

        return $this;
    }

    public function setGender(Gender $gender)
    {
        $this->params->setGender($gender);

        return $this;
    }

    public function setDateOfBirth(Carbon $dateOfBirth)
    {
        $this->params->setDateOfBirth($dateOfBirth);

        return $this;
    }

    public function setTravelPolicy(string $travelPolicy)
    {
        $this->params->setTravelPolicy($travelPolicy);

        return $this;
    }

    public function setEmergencyContact(EmergencyContact $emergencyContact)
    {
        $this->params->setEmergencyContact($emergencyContact);

        return $this;
    }

    public function setInvoiceProfiles(array $invoiceProfiles)
    {
        $this->params->setInvoiceProfiles($invoiceProfiles);

        return $this;
    }

    public function setCostCenter(string $costCenter)
    {
        $this->params->setCostCenter($costCenter);

        return $this;
    }

    public function setManager(string $manager)
    {
        $this->params->setManager($manager);

        return $this;
    }

    private function hasCustomUserData()
    {
        return $this->params->hasCustomUserData();
    }

    private function hasEnterpriseData()
    {
        return $this->params->hasEnterpriseDat();
    }
}
