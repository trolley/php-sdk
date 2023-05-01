<?php
namespace Trolley;

/**
 * Trolley Recipient Logs module
 * PHP Version 5
 * Creates and manages Trolley Recipients' Logs
 *
 * @package   Trolley
 *
 */
class RecipientLogs extends Base
{
    /**
     * @access protected
     * @var array registry of recipient log data
     */
    protected $_attributes = [
        "via" => "",
        "ipAddress" => "",
        "userId" => "",
        "type" => "",
        "fields" => "",
        "createdAt" => ""
    ];

    /**
     * sets instance properties from an array of values
     *
     * @ignore
     * @access protected
     * @param array $transactionAttribs array of transaction data
     * @return void
     */
    protected function _initialize($attributes) {
        $fields = [
            "via",
            "ipAddress",
            "userId",
            "type",
            "fields",
            "createdAt"
        ];

        foreach ($fields as $key => $field) {
            if (is_numeric($key)) {
                if (isset($attributes[$field])) {
                    $this->_set($field, $attributes[$field]);
                }
            } else {
                if (isset($attributes[$key])) {
                    $this->_set($key, call_user_func($field, $attributes[$key]));
                }
            }
            
        }
    }

   /**
     *  factory method: returns an instance of Recipient
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Recipient
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

}

class_alias('Trolley\RecipientLogs', 'Trolley_RecipientLogs');
