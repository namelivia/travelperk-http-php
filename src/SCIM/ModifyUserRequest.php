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

    public function save() :object
    {
        return $this->travelPerk->putJson(implode('/', ['scim', 'Users', $this->id]), $this->params->asArray());
    }

    public function setLanguage(string $language) :ModifyUserRequest
    {
        $this->params->setLanguage($language);

        return $this;
    }

    public function setLocale(string $locale) :ModifyUserRequest
    {
        $this->params->setLocale($locale);

        return $this;
    }

    public function setTitle(string $title) :ModifyUserRequest
    {
        $this->params->setTitle($title);

        return $this;
    }

    public function setExternalId(string $externalId) :ModifyUserRequest
    {
        $this->params->setExternalId($externalId);

        return $this;
    }

    public function setPhoneNumber(string $number) :ModifyUserRequest
    {
        $this->params->setPhoneNumber($number);

        return $this;
    }

    public function setGender(string $gender) :ModifyUserRequest
    {
        $this->params->setGender($gender);

        return $this;
    }

    public function setDateOfBirth(Carbon $dateOfBirth) :ModifyUserRequest
    {
        $this->params->setDateOfBirth($dateOfBirth);

        return $this;
    }

    public function setTravelPolicy(string $travelPolicy) :ModifyUserRequest
    {
        $this->params->setTravelPolicy($travelPolicy);

        return $this;
    }

    public function setEmergencyContact(string $emergencyContactName, string $emergencyContactPhone) :ModifyUserRequest
    {
        $emergencyContact = new EmergencyContact($emergencyContactName, $emergencyContactPhone);
        $this->params->setEmergencyContact($emergencyContact);

        return $this;
    }

    public function setInvoiceProfiles(array $invoiceProfiles) :ModifyUserRequest
    {
        $this->params->setInvoiceProfiles($invoiceProfiles);

        return $this;
    }

    public function setCostCenter(string $costCenter) :ModifyUserRequest
    {
        $this->params->setCostCenter($costCenter);

        return $this;
    }

    public function setManager(string $manager) :ModifyUserRequest
    {
        $this->params->setManager($manager);

        return $this;
    }

    public function setHonorificPrefix(string $honorificPrefix) :ModifyUserRequest
    {
        $this->params->setHonorificPrefix($honorificPrefix);

        return $this;
    }

    public function setMiddleName(string $middleName) :ModifyUserRequest
    {
        $this->params->setMiddleName($middleName);

        return $this;
    }

    private function hasCustomUserData() :bool
    {
        return $this->params->hasCustomUserData();
    }

    private function hasEnterpriseData() :bool
    {
        return $this->params->hasEnterpriseData();
    }
}
