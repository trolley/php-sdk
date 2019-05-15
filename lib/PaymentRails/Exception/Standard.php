<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when a standard error request is received
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Standard extends Exception
{
  protected $errorBody;

  public function __construct($errorBody)
  {
      $errors = json_decode($errorBody)->errors;
      $message = "";
      foreach ($errors as $e) {
        if (isset($e->field)) {
          $message = $message . $e->field . " " . $e->code . ": " . $e->message . "\n";
        } else {
          $message = $message . $e->code . ": " . $e->message . "\n";
        }
      }
      $this->message = $message;
  }
}
class_alias('PaymentRails\Exception\Standard', 'PaymentRails_Exception_Standard');
