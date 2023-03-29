<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when an unexpected response is returned
 *
 * @package    Trolley
 * @subpackage Exception
 */
class Unexpected extends Exception
{

}
class_alias('Trolley\Exception\Unexpected', 'Trolley_Exception_Unexpected');
