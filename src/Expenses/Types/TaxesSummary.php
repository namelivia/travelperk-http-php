<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class TaxesSummary
{
    /**
     * @var string
     */
    public $taxRegime;
    /**
     * @var string
     */
    public $subtotal;
    /**
     * @var string
     */
    public $taxPercentage;
    /**
     * @var string
     */
    public $taxAmount;
    /**
     * @var string
     */
    public $total;
}
