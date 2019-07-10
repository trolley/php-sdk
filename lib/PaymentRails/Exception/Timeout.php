<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when the the CURL connection times out
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Timeout extends Exception
{
  // protected $errorBody;

  public function __construct()
  {
      $this->message = "The request has timed out.";
  }
}
class_alias('PaymentRails\Exception\Timeout', 'PaymentRails_Exception_Timeout');
