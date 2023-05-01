<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when the SSL certificate fails verification.
 *
 * @package    Trolley
 * @subpackage Exception
 */
class NotFound extends Exception
{

}
class_alias('Trolley\Exception\NotFound', 'Trolley_Exception_NotFound');
