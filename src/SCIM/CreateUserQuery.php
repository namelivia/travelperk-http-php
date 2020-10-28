<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Carbon\Carbon;
use JsonMapper\JsonMapper;
use Namelivia\TravelPerk\Api\TravelPerk;
use Namelivia\TravelPerk\SCIM\Users\User;

class CreateUserQuery
{
    private $params;
    private $travelPerk;

    public function __construct(
        TravelPerk $travelPerk,
        JsonMapper $mapper,
        string $username,
        bool $active,
        NameInputParams $name
    ) {
        $this->travelPerk = $travelPerk;
        $this->mapper = $mapper;
        $this->params = new CreateUserInputParams($username, $active, $name);
    }

    //TODO: This is temporary
    private function execute(string $method, string $url, string $class, array $params = null)
    {
        $result = new $class();
        if (is_null($params)) {
            $response = $this->travelPerk->{$method}($url);
        } else {
            $response = $this->travelPerk->{$method}($url, $params);
        }

        //TODO: This won't go here
        $decoded = json_decode($response);
        $decoded->enterprise_extension = $decoded->{'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User'};
        $decoded->travelperk_extension = $decoded->{'urn:ietf:params:scim:schemas:extension:travelperk:2.0:User'};
        $decoded->enterprise_extension->manager->ref = $decoded->enterprise_extension->manager->{'$ref'};
        //TODO

        $this->mapper->mapObject(
            $decoded,
            $result
        );

        return $result;
    }

    public function save(): object
    {
        return $this->execute('post', implode('/', ['scim', 'Users']), User::class, $this->params->asArray());
    }

    public function setLanguage(string $language): CreateUserQuery
    {
        $this->params->setLanguage($language);

        return $this;
    }

    public function setLocale(string $locale): CreateUserQuery
    {
        $this->params->setLocale($locale);

        return $this;
    }

    public function setTitle(string $title): CreateUserQuery
    {
        $this->params->setTitle($title);

        return $this;
    }

    public function setExternalId(string $externalId): CreateUserQuery
    {
        $this->params->setExternalId($externalId);

        return $this;
    }

    public function setPhoneNumber(string $number): CreateUserQuery
    {
        $this->params->setPhoneNumber($number);

        return $this;
    }

    public function setGender(string $gender): CreateUserQuery
    {
        $this->params->setGender($gender);

        return $this;
    }

    public function setDateOfBirth(Carbon $dateOfBirth): CreateUserQuery
    {
        $this->params->setDateOfBirth($dateOfBirth);

        return $this;
    }

    public function setTravelPolicy(string $travelPolicy): CreateUserQuery
    {
        $this->params->setTravelPolicy($travelPolicy);

        return $this;
    }

    public function setEmergencyContact(EmergencyContact $emergencyContact): CreateUserQuery
    {
        $this->params->setEmergencyContact($emergencyContact);

        return $this;
    }

    public function setInvoiceProfiles(array $invoiceProfiles): CreateUserQuery
    {
        $this->params->setInvoiceProfiles($invoiceProfiles);

        return $this;
    }

    public function setCostCenter(string $costCenter): CreateUserQuery
    {
        $this->params->setCostCenter($costCenter);

        return $this;
    }

    public function setManager(string $manager): CreateUserQuery
    {
        $this->params->setManager($manager);

        return $this;
    }

    public function setHonorificPrefix(string $honorificPrefix): CreateUserQuery
    {
        $this->params->setHonorificPrefix($honorificPrefix);

        return $this;
    }

    public function setMiddleName(string $middleName): CreateUserQuery
    {
        $this->params->setMiddleName($middleName);

        return $this;
    }

    private function hasCustomUserData(): bool
    {
        return $this->params->hasCustomUserData();
    }

    private function hasEnterpriseData(): bool
    {
        return $this->params->hasEnterpriseDat();
    }
}
