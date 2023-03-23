<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when Authentication fails
 *
 * @package    Trolley
 * @subpackage Exception
 */
class Authentication extends Exception
{

}
class_alias('Trolley\Exception\Authentication', 'Trolley_Exception_Authentication');
