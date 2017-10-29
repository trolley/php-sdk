<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Configuration extends Exception
{

}
class_alias('PaymentRails\Exception\Configuration', 'PaymentRails_Exception_Configuration');
