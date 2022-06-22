<?php
namespace PaymentRails\Exception;

use PaymentRails\Exception;

/**
* Raised when a standard error request is received
*
* @package    PaymentRails
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
class_alias('PaymentRails\Exception\Standard', 'PaymentRails_Exception_Standard');
