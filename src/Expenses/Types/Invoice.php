<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class Invoice
{
  /**
   * @var string
  */
  public $serialNumber;

  /**
   * @var string
   */
  public $profileId;

  /**
   * @var string
   */
  public $profileName;

  /**
   * @var BillingInformation
   */
  public $billingInformation;

  /**
   * @var string
   */
  public $mode;

  /**
   * @var string
   */
  public $status;


  /**
   * @var string
   */
  public $issuingDate;

  /**
   * @var string
   */
  public $billingPeriod;

  /**
   * @var string
   */
  public $fromDate;

  /**
   * @var string
   */
  public $toDate;

  /**
   * @var string
   */
  public $dueDate;

  /**
   * @var string
   */
  public $currency;

  /**
   * @var string
   */
  public $total;

  /**
   * @var Lines
   */
  public $lines;

  /**
   * @var TaxesSummary[]
   */
  public $taxesSummary;

  /**
   * @var string
   */
  public $reference;

  /**
   * @var TravelperkBankAccount
   */
  public $travelperkBankAccount;

  /**
   * @var string
   */
  public $pdf;
}
