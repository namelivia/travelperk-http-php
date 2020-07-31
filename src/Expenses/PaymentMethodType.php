<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses;

use Namelivia\TravelPerk\BasicEnum;

class PaymentMethodType extends BasicEnum
{
    const CREDIT_CARD = 'credit_card';
    const INSTANT_DIRECT_DEBIT = 'instant_direct_debit';
    const MANUAL_DIRECT_DEBIT = 'manual_direct_debit';
    const BANK_TRANSFER = 'bank_transfer';

    private $paymentMethodType;

    public function __construct(string $paymentMethodType)
    {
        parent::checkValidity($paymentMethodType);
        $this->paymentMethodType = $paymentMethodType;
    }

    public function __toString()
    {
        return $this->paymentMethodType;
    }
}
