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

}
class_alias('PaymentRails\Exception\Timeout', 'PaymentRails_Exception_Timeout');
