<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class ReplaceUserInputParams
{
    private $userName;
    private $active;
    private $name;
    private $language;
    private $locale;
    private $title;
    private $externalId;
    private $phoneNumbers;

    public function __construct(string $userName, bool $active, NameInputParams $name)
    {
        //TODO: Many fields are still missing
        $this->userName = $userName;
        $this->active = $active;
        $this->name = $name;
        $this->phoneNumbers = [];
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

    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        array_push($this->phoneNumbers, $phoneNumber);

        return $this;
    }

    public function asArray()
    {
        return array_filter([
            'userName' => $this->userName,
            'name'     => $this->name->asArray(),
            'active'   => $this->active,
            'preferredLanguage' => isset($this->language) ? strval($this->language) : null,
            'locale'   => $this->locale,
            'title'   => $this->title,
            'externalId'   => $this->externalId,
            'phoneNumbers'   => empty($this->phoneNumbers) ? null : array_map(function($phoneNumber) {
                return $phoneNumber->asArray();
            }, $this->phoneNumbers),
        ]);
    }
}
