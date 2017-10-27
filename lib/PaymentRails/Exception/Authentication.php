<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when Authentication fails
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Authentication extends Exception
{

}
class_alias('PaymentRails\Exception\Authentication', 'PaymentRails_Exception_Authentication');
