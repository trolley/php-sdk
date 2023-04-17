<?php
namespace Trolley\Exception;

use Trolley\Exception;

/**
* Raised when a standard error request is received
*
* @package    Trolley
* @subpackage Exception
*/
class Standard extends Exception
{
	protected $errorBody;

	/**
	 * @var $errorBody string|array
	 */
	public function __construct($errorBody)
	{
		$message = '';
		if (is_array($errorBody)) {
			foreach($errorBody as $e) {
				$message .= "{$e['code']}: {$e['message']}";
				if (!empty($e['field'])) {
					$message .= " (field: {$e['field']})";
				}
				$message .= "\n";
			}
		} elseif (is_string($errorBody)) {
			$message = $errorBody;
		}
		$this->message = $message;
	}
}
class_alias('Trolley\Exception\Standard', 'Trolley_Exception_Standard');
