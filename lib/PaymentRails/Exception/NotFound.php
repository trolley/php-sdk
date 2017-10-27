<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class NotFound extends Exception
{

}
class_alias('PaymentRails\Exception\NotFound', 'PaymentRails_Exception_NotFound');
