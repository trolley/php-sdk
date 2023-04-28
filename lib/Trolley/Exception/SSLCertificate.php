<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    Trolley
 * @subpackage Exception
 */
class SSLCertificate extends Exception
{

}
class_alias('Trolley\Exception\SSLCertificate', 'Trolley_Exception_SSLCertificate');
