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

    public function setHonorificPrefix(string $honorificPrefix): NameInputParams
    {
        $this->honorificPrefix = $honorificPrefix;

        return $this;
    }

    public function setMiddleName(string $middleName): NameInputParams
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function asArray(): array
    {
        return array_filter([
            'givenName'       => $this->givenName,
            'familyName'      => $this->familyName,
            'honorificPrefix' => $this->honorificPrefix,
            'middleName'      => $this->middleName,
        ]);
    }
}
