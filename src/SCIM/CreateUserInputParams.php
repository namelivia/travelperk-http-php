<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

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
            'phoneNumbers'   => is_null($this->phoneNumber) ? null : [
                [
                    'value' => $this->phoneNumber,
                    'type' => 'work',
                ]
            ]
        ]);
    }
}
