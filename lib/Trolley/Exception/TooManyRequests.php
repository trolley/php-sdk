<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when you're request rate limited
 *
 * @package    Trolley
 * @subpackage Exception
 */
class TooManyRequests extends Exception
{

}
class_alias('Trolley\Exception\TooManyRequests', 'Trolley_Exception_TooManyRequests');
