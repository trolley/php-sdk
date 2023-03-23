<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    Trolley
 * @subpackage Exception
 */
class Configuration extends Exception
{

}
class_alias('Trolley\Exception\Configuration', 'Trolley_Exception_Configuration');
