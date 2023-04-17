<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when the the CURL connection times out
 *
 * @package    Trolley
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
class_alias('Trolley\Exception\Timeout', 'Trolley_Exception_Timeout');
