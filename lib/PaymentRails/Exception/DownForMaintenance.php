<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when the service is down for maintaince
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class DownForMaintenance extends Exception
{

}
class_alias('PaymentRails\Exception\DownForMaintenance', 'PaymentRails_Exception_DownForMaintenance');
