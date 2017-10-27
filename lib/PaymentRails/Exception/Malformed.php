<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when a malformed request is received
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Malformed extends Exception
{

}
class_alias('PaymentRails\Exception\Malformed', 'PaymentRails_Exception_Malformed');
