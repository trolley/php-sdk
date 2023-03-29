<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when a malformed request is received
 *
 * @package    Trolley
 * @subpackage Exception
 */
class Malformed extends Exception
{

}
class_alias('Trolley\Exception\Malformed', 'Trolley_Exception_Malformed');
