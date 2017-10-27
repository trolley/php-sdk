<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when you're request rate limited
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class TooManyRequests extends Exception
{

}
class_alias('PaymentRails\Exception\TooManyRequests', 'PaymentRails_Exception_TooManyRequests');
