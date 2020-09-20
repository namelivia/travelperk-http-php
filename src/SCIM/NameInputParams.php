<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class NameInputParams
{
    private $givenName;
    private $familyName;
    private $honorificPrefix;
    private $middleName;

    public function __construct(string $givenName, string $familyName)
    {
        $this->givenName = $givenName;
        $this->familyName = $familyName;
    }

    public function setHonorificPrefix(string $honorificPrefix) {
        $this->honorificPrefix = $honorificPrefix;
        return $this;
    }

    public function setMiddleName(string $middleName) {
        $this->middleName = $middleName;
        return $this;
    }

    public function asArray()
    {
        return array_filter([
            'givenName'  => $this->givenName,
            'familyName' => $this->familyName,
            'honorificPrefix' => $this->honorificPrefix,
            'middleName' => $this->middleName,
        ]);
    }
}
