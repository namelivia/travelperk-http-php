<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class InvoicesPage
{
  /**
   * @var integer
  */
  public $offset;

  /**
   * @var integer
   */
  public $limit;

  /**
   * @var integer
   */
  public $total;

  /**
   * @var Invoice[]
   */
  public $invoices;
}
