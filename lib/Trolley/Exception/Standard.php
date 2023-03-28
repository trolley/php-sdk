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
	private $errorArray;

	/**
	 * @var $errorBody string|array
	 */
	public function __construct($errorBody)
	{
		$message = '';

		if (is_string($errorBody)) {
			$errorBody = json_decode($errorBody, true);
		}

		$this->errorArray = $errorBody["errors"];
		$message = json_encode($this->errorArray);

		$this->message = $message;
	}

	/**
	 * Get the error messages as Array.
	 */
	public function getAllErrorsAsArray(){
		return $this->errorArray;
	}
}
class_alias('Trolley\Exception\Standard', 'Trolley_Exception_Standard');
