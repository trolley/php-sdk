<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    Trolley
 * @subpackage Exception
 */
class Connection extends Exception
{

}
class_alias('Trolley\Exception\Connection', 'Trolley_Exception_Connection');
