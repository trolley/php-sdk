<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
 * Raised when the service is down for maintaince
 *
 * @package    Trolley
 * @subpackage Exception
 */
class DownForMaintenance extends Exception
{

}
class_alias('Trolley\Exception\DownForMaintenance', 'Trolley_Exception_DownForMaintenance');
