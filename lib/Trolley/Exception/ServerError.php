<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when there is an internal server erro
 *
 * @package    Trolley
 * @subpackage Exception
 */
class ServerError extends Exception
{

}
class_alias('Trolley\Exception\ServerError', 'Trolley_Exception_ServerError');
