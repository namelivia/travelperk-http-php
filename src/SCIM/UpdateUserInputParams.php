<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\SCIM\NameInputParams;

class UpdateUserInputParams
{
    private $userName;
    private $active;
    private $name;

    public function setUserName(string $userName)
    {
        $this->userName = $userName;
        return $this;
    }

    public function setActive(boolean $active)
    {
        $this->active = $active;
        return $this;
    }

    public function setName(NameInputParams $name)
    {
        $this->name = $name;
        return $this;
    }
}
