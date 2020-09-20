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

    public function __construct(string $userName, bool $active, NameInputParams $name)
    {
        //TODO: Many fields are still missing
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

    private function hasEnterpriseData()
    {
        return array_filter([$this->gender, $this->dateOfBirth, $this->travelPolicy]);
    }

    public function asArray()
    {
        $data = [
            'userName' => $this->userName,
            'name'     => $this->name->asArray(),
            'active'   => $this->active,
            'preferredLanguage' => isset($this->language) ? strval($this->language) : null,
            'locale'   => $this->locale,
            'title'   => $this->title,
            'externalId'   => $this->externalId,
            'phoneNumbers'   => is_null($this->phoneNumber) ? null : [
                [
                    'value' => $this->phoneNumber,
                    'type' => 'work',
                ]
            ],
        ];

        if ($this->hasEnterpriseData()) {
            $data["urn:ietf:params:scim:schemas:extension:enterprise:2.0:User"] = [
                'gender'   => $this->gender ? strval($this->gender) : null,
                'dateOfBirth'   => $this->dateOfBirth ? $this->dateOfBirth->format('Y/m/d') : null,
                'travelPolicy'   => $this->travelPolicy,
            ];
        }
        return array_filter($data);
    }
}
