<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when you're not authorized to fetch this resource
 *
 * @package    Trolley
 * @subpackage Exception
 */
class Authorization extends Exception
{

}
class_alias('Trolley\Exception\Authorization', 'Trolley_Exception_Authorization');
