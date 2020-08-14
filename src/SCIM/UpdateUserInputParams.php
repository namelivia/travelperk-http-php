<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

use Namelivia\TravelPerk\SCIM\NameInputParams;

class UpdateUserInputParams
{
    private $userName;
    private $active;
    private $name;

    public function __construct(string $userName, bool $active, NameInputParams $name)
    {
        #TODO: Many fields are still missing
        $this->userName = $userName;
        $this->active = $active;
        $this->name = $name;
    }

    public function asArray()
    {
        return [
            'userName' => $this->userName,
            'name' => $this->name->asArray(),
            'active' => $this->active,
        ];
    }
}
