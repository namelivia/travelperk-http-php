<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\SCIM;

class PhoneNumber
{
    private $value;
    private $type;

    public function __construct(string $value, string $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    public function asArray()
    {
        return [
            'value'  => $this->value,
            'type' => $this->type,
        ];
    }
}
