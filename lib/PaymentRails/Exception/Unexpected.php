<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when an unexpected response is returned
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Unexpected extends Exception
{

}
class_alias('PaymentRails\Exception\Unexpected', 'PaymentRails_Exception_Unexpected');
