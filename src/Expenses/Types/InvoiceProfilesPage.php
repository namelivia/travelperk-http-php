<?php

declare(strict_types=1);

namespace Namelivia\TravelPerk\Expenses\Types;

class InvoiceProfilesPage
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
   * @var InvoiceProfile[]
   */
  public $profiles;
}
