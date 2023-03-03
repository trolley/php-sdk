<?php

namespace PaymentRails;

/**
 * super class for all Trolley (PaymentRails) exceptions
 *
 * @package    PaymentRails
 * @subpackage Exception
 */

class Exception extends \Exception
{
}

class_alias('PaymentRails\Exception', 'PaymentRails_Exception');
