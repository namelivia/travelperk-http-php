<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Carbon\Carbon;

class CreateUserInputParams
{
    private $userName;
    private $active;
    private $name;
    private $language;
    private $locale;
    private $title;
    private $externalId;
    private $phoneNumber;
    private $gender;
    private $dateOfBirth;
    private $travelPolicy;
    private $invoiceProfiles;
    private $emergencyContact;
    private $costCenter;
    private $manager;

    public function __construct(string $userName, bool $active, NameInputParams $name)
    {
        $this->userName = $userName;
        $this->active = $active;
        $this->name = $name;
    }

    public function setLanguage(string $language):CreateUserInputParams
    {
        $this->language = new Language($language);

        return $this;
    }

    public function setLocale(string $locale):CreateUserInputParams
    {
        $this->locale = $locale;

        return $this;
    }

    public function setTitle(string $title) :CreateUserInputParams
    {
        $this->title = $title;

        return $this;
    }

    public function setExternalId(string $externalId) :CreateUserInputParams
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function setPhoneNumber(string $number) :CreateUserInputParams
    {
        $this->phoneNumber = $number;

        return $this;
    }

    public function setGender(string $gender) :CreateUserInputParams
    {
        $this->gender = new Gender($gender);

        return $this;
    }

    public function setDateOfBirth(Carbon $dateOfBirth) :CreateUserInputParams
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function setTravelPolicy(string $travelPolicy) :CreateUserInputParams
    {
        $this->travelPolicy = $travelPolicy;

        return $this;
    }

    public function setEmergencyContact(EmergencyContact $emergencyContact) :CreateUserInputParams
    {
        $this->emergencyContact = $emergencyContact;

        return $this;
    }

    public function setInvoiceProfiles(array $invoiceProfiles) :CreateUserInputParams
    {
        $this->invoiceProfiles = new InvoiceProfiles($invoiceProfiles);

        return $this;
    }

    public function setCostCenter(string $costCenter) :CreateUserInputParams
    {
        $this->costCenter = $costCenter;

        return $this;
    }

    public function setManager(string $manager) :CreateUserInputParams
    {
        $this->manager = $manager;

        return $this;
    }

    public function setHonorificPrefix(string $honorificPrefix) :CreateUserInputParams
    {
        $this->name->setHonorificPrefix($honorificPrefix);

        return $this;
    }

    public function setMiddleName(string $middleName) :CreateUserInputParams
    {
        $this->name->setMiddleName($middleName);

        return $this;
    }

    private function hasCustomUserData(): bool
    {
        return !empty(array_filter([
            $this->gender,
            $this->dateOfBirth,
            $this->travelPolicy,
            empty($this->invoicesProfiles) ? null : $this->invoicesProfiles,
            $this->emergencyContact,
        ]));
    }

    private function hasEnterpriseData(): bool
    {
        return !empty(array_filter([
            $this->costCenter,
            $this->manager,
        ]));
    }

    public function asArray() :array
    {
        $data = array_filter([
            'userName'          => $this->userName,
            'name'              => $this->name->asArray(),
            'active'            => $this->active,
            'preferredLanguage' => isset($this->language) ? strval($this->language) : null,
            'locale'            => $this->locale,
            'title'             => $this->title,
            'externalId'        => $this->externalId,
            'phoneNumbers'      => is_null($this->phoneNumber) ? null : [
                [
                    'value' => $this->phoneNumber,
                    'type'  => 'work',
                ],
            ],
        ]);

        if ($this->hasCustomUserData()) {
            $data['urn:ietf:params:scim:schemas:extension:travelperk:2.0:User'] = array_filter([
                'gender'             => $this->gender ? strval($this->gender) : null,
                'dateOfBirth'        => $this->dateOfBirth ? $this->dateOfBirth->format('Y/m/d') : null,
                'travelPolicy'       => $this->travelPolicy,
                'emergencyContact'   => $this->emergencyContact ? $this->emergencyContact->asArray() : null,
                'invoiceProfiles'    => $this->invoiceProfiles ? $this->invoiceProfiles->asArray() : null,
            ]);
        }

        if ($this->hasEnterpriseData()) {
            $data['urn:ietf:params:scim:schemas:extension:enterprise:2.0:User'] = array_filter([
                'costCenter'   => $this->costCenter,
                'manager'      => $this->manager ? ['value' => $this->manager] : null,
            ]);
        }

        return $data;
    }
}
