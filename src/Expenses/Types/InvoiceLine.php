<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class InvoiceLine
{
    /**
     * @var string
     */
    public $expenseDate;

    /**
     * @var string
     */
    public $description;

    /**
     * @var integer
     */
    public $quantity;

    /**
     * @var string
     */
    public $unitPrice;

    /**
     * @var string
     */
    public $nonTaxableUnitPrice;

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
    public $taxRegime;

    /**
     * @var string
     */
    public $totalAmount;

    /**
     * @var Metadata
     */
    public $metadata;

    /**
     * @var string
     */
    public $invoiceSerialNumber;

    /**
     * @var string
     */
    public $profileId;

    /**
     * @var string
     */
    public $profileName;

    /**
     * @var string
     */
    public $invoiceMode;

    /**
     * @var string
     */
    public $invoiceStatus;

    /**
     * @var string
     */
    public $issuingDate;

    /**
     * @var string
     */
    public $dueDate;

    /**
     * @var string
     */
    public $currency;
}
