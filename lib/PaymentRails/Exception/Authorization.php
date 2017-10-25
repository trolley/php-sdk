<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when you're not authorized to fetch this resource
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class Authorization extends Exception
{

}
class_alias('PaymentRails\Exception\Authorization', 'PaymentRails_Exception_Authorization');
