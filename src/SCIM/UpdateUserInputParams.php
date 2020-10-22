<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class UpdateUserInputParams
{
    private $userName;
    private $active;
    private $name;

    public function setUserName(string $userName): UpdateUserInputParams
    {
        $this->userName = $userName;

        return $this;
    }

    public function setActive(bool $active): UpdateUserInputParams
    {
        $this->active = $active;

        return $this;
    }

    public function setName(NameInputParams $name): UpdateUserInputParams
    {
        $this->name = $name;

        return $this;
    }

    public function asArray(): array
    {
        return array_filter([
            'userName' => $this->userName,
            'name'     => $this->name ? $this->name->asArray() : null,
            'active'   => $this->active,
        ], function ($value) {return !is_null($value); });
    }
}
