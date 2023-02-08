<?php
namespace PaymentRails;

/**
 * Trolley (PaymentRails) SDK Version
 * stores version information about the Trolley SDK
 */
class Version
{
    /**
     * class constants
     */
    const MAJOR = 2;
    const MINOR = 1;
    const TINY = 5;

    /**
     * @ignore
     * @access protected
     */
    protected function  __construct()
    {
    }

    /**
     *
     * @return string the current SDK version
     */
    public static function get()
    {
        return self::MAJOR . '.' . self::MINOR . '.' . self::TINY;
    }
}

class_alias('PaymentRails\Version', 'PaymentRails_Version');
