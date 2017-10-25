<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Connection extends Exception
{

}
class_alias('PaymentRails\Exception\Connection', 'PaymentRails_Exception_Connection');
