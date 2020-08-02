<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\BasicEnum;

class Status extends BasicEnum
{
    const DRAFT = 'draft';
    const OPEN = 'open';
    const PAID = 'paid';
    const UNPAID = 'unpaid';

    private $status;

    public function __construct(string $status)
    {
        parent::checkValidity($status);
        $this->status = $status;
    }

    public function __toString()
    {
        return $this->status;
    }
}
