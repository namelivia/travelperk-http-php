<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\Api\TravelPerk;

class ModifyUserRequest
{
    private $params;
    private $travelPerk;
    private $id;

    public function __construct(
        int $id,
        TravelPerk $travelPerk,
        string $username,
        bool $active,
        NameInputParams $name
    ) {
        $this->id = $id;
        $this->params = new ReplaceUserInputParams($username, $active, $name);
        $this->travelPerk = $travelPerk;
    }

    public function save()
    {
        return $this->travelPerk->putJson(implode('/', ['scim', 'Users', $this->id]), $this->params->asArray());
    }

    public function setLanguage(string $language)
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

    public function setGender(string $gender)
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

    public function setEmergencyContact(string $emergencyContactName, string $emergencyContactPhone)
    {
        $emergencyContact = new EmergencyContact($emergencyContactName, $emergencyContactPhone);
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

    public function setHonorificPrefix(string $honorificPrefix)
    {
        $this->params->setHonorificPrefix($honorificPrefix);

        return $this;
    }

    public function setMiddleName(string $middleName)
    {
        $this->params->setMiddleName($middleName);

        return $this;
    }

    private function hasCustomUserData()
    {
        return $this->params->hasCustomUserData();
    }

    private function hasEnterpriseData()
    {
        return $this->params->hasEnterpriseData();
    }
}
