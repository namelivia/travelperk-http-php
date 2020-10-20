<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Carbon\Carbon;

class ReplaceUserInputParams
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

    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    public function setLocale(string $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function setExternalId(string $externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function setPhoneNumber(string $number)
    {
        $this->phoneNumber = $number;

        return $this;
    }

    public function setGender(Gender $gender)
    {
        $this->gender = $gender;

        return $this;
    }

    public function setDateOfBirth(Carbon $dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function setTravelPolicy(string $travelPolicy)
    {
        $this->travelPolicy = $travelPolicy;

        return $this;
    }

    public function setEmergencyContact(EmergencyContact $emergencyContact)
    {
        $this->params->setEmergencyContact($emergencyContact);

        return $this;
    }

    public function setInvoiceProfiles(array $invoiceProfiles)
    {
        $this->invoiceProfiles = new InvoiceProfiles($invoiceProfiles);

        return $this;
    }

    public function setCostCenter(string $costCenter)
    {
        $this->costCenter = $costCenter;

        return $this;
    }

    public function setManager(string $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    public function setHonorificPrefix(string $honorificPrefix)
    {
        $this->name->setHonorificPrefix($honorificPrefix);

        return $this;
    }

    public function setMiddleName(string $middleName)
    {
        $this->name->setMiddleName($middleName);

        return $this;
    }

    private function hasCustomUserData()
    {
        return array_filter([
            $this->gender,
            $this->dateOfBirth,
            $this->travelPolicy,
            empty($this->invoicesProfiles) ? null : $this->invoicesProfiles,
            $this->emergencyContact,
        ]);
    }

    private function hasEnterpriseData()
    {
        return array_filter([
            $this->costCenter,
            $this->manager,
        ]);
    }

    public function asArray()
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
