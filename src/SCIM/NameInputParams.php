<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class NameInputParams
{
    private $givenName;
    private $familyName;

    public function __construct(string $givenName, string $familyName)
    {
        //TODO: Many fields are still missing
        $this->givenName = $givenName;
        $this->familyName = $familyName;
    }

    public function asArray()
    {
        return [
            'givenName'  => $this->givenName,
            'familyName' => $this->familyName,
        ];
    }
}
