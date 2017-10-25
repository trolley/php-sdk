<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when there is an internal server erro
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class ServerError extends Exception
{

}
class_alias('PaymentRails\Exception\ServerError', 'PaymentRails_Exception_ServerError');
