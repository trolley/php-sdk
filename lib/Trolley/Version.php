<?php
namespace Trolley;

/**
 * Trolley SDK Version
 * stores version information about the Trolley SDK
 */
class Version
{
    /**
     * class constants
     */
    const MAJOR = 3;
    const MINOR = 0;
    const TINY = 2;

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

class_alias('Trolley\Version', 'Trolley_Version');
