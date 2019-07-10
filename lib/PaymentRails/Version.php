<?php
namespace PaymentRails;

/**
 * PaymentRails Library Version
 * stores version information about the PaymentRails library
 */
class Version
{
    /**
     * class constants
     */
    const MAJOR = 2;
    const MINOR = 0;
    const TINY = 1;

    /**
     * @ignore
     * @access protected
     */
    protected function  __construct()
    {
    }

    /**
     *
     * @return string the current library version
     */
    public static function get()
    {
        return self::MAJOR . '.' . self::MINOR . '.' . self::TINY;
    }
}

class_alias('PaymentRails\Version', 'PaymentRails_Version');
