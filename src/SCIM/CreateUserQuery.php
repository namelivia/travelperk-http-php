<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Carbon\Carbon;
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

    public function save() :object
    {
        return $this->travelPerk->postJson(implode('/', ['scim', 'Users']), $this->params->asArray());
    }

    public function setLanguage(string $language) :CreateUserQuery
    {
        $this->params->setLanguage($language);

        return $this;
    }

    public function setLocale(string $locale) :CreateUserQuery
    {
        $this->params->setLocale($locale);

        return $this;
    }

    public function setTitle(string $title) :CreateUserQuery
    {
        $this->params->setTitle($title);

        return $this;
    }

    public function setExternalId(string $externalId) :CreateUserQuery
    {
        $this->params->setExternalId($externalId);

        return $this;
    }

    public function setPhoneNumber(string $number) :CreateUserQuery
    {
        $this->params->setPhoneNumber($number);

        return $this;
    }

    public function setGender(string $gender) :CreateUserQuery
    {
        $this->params->setGender($gender);

        return $this;
    }

    public function setDateOfBirth(Carbon $dateOfBirth) :CreateUserQuery
    {
        $this->params->setDateOfBirth($dateOfBirth);

        return $this;
    }

    public function setTravelPolicy(string $travelPolicy) :CreateUserQuery
    {
        $this->params->setTravelPolicy($travelPolicy);

        return $this;
    }

    public function setEmergencyContact(EmergencyContact $emergencyContact) :CreateUserQuery
    {
        $this->params->setEmergencyContact($emergencyContact);

        return $this;
    }

    public function setInvoiceProfiles(array $invoiceProfiles) :CreateUserQuery
    {
        $this->params->setInvoiceProfiles($invoiceProfiles);

        return $this;
    }

    public function setCostCenter(string $costCenter) :CreateUserQuery
    {
        $this->params->setCostCenter($costCenter);

        return $this;
    }

    public function setManager(string $manager) :CreateUserQuery
    {
        $this->params->setManager($manager);

        return $this;
    }

    public function setHonorificPrefix(string $honorificPrefix) :CreateUserQuery
    {
        $this->params->setHonorificPrefix($honorificPrefix);

        return $this;
    }

    public function setMiddleName(string $middleName) :CreateUserQuery
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
        return $this->params->hasEnterpriseDat();
    }
}
