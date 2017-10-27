<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    PaymentRails
 * @subpackage Exception
 */
class SSLCertificate extends Exception
{

}
class_alias('PaymentRails\Exception\SSLCertificate', 'PaymentRails_Exception_SSLCertificate');
