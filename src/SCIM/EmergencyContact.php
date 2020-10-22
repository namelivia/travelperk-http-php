<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class EmergencyContact
{
    private $name;
    private $phone;

    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    public function asArray(): array
    {
        return [
            'name'  => $this->name,
            'phone' => $this->phone,
        ];
    }
}
