<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class ReplaceUserInputParams
{
    private $userName;
    private $active;
    private $name;
    private $language;

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

    public function asArray()
    {
        return array_filter([
            'userName' => $this->userName,
            'name'     => $this->name->asArray(),
            'active'   => $this->active,
            'preferredLanguage' => isset($this->language) ? strval($this->language) : null,
        ]);
    }
}
