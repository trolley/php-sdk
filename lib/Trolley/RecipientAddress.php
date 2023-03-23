<?php
namespace Trolley;

/**
 * Trolley Recipient module
 * PHP Version 5
 * Creates and manages Trolley Recipients
 *
 * @package   Trolley
 *
 */
class RecipientAddress extends Base
{
    protected $_attributes = [
        "city" => "",
        "country" => "",
        "phone" => "",
        "postalCode" => "",
        "region" => "",
        "street1" => "",
        "street2" => "",
    ];

    protected function _initialize($attributes) {
        $fields = [
            "city",
            "country",
            "phone",
            "postalCode",
            "region",
            "street1",
            "street2",
        ];
        foreach ($fields as $field) {
            if (isset($attributes[$field])) {
                $this->_set($field, $attributes[$field]);
            }
        }
    }

    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }
    
}
class_alias('Trolley\RecipientAddress', 'Trolley_RecipientAddress');