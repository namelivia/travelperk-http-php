<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class InvoiceLinesPage
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
   * @var InvoiceLine[]
   */
  public $invoiceLines;
}
