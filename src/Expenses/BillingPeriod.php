<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\BasicEnum;

class BillingPeriod extends BasicEnum
{
    const INSTANT = 'instant';
    const WEEKLY = 'weekly';
    const BIWEEKLY = 'biweekly';
    const MONTHLY = 'monthly';

    private $billingPeriod;

    public function __construct(string $billingPeriod)
    {
        parent::checkValidity($billingPeriod);
        $this->billingPeriod = $billingPeriod;
    }

    public function __toString()
    {
        return $this->billingPeriod;
    }
}
