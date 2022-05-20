<?php
namespace Test;

// require_once __DIR__ . '/Helper.php';
require_once '../vendor/autoload.php';

date_default_timezone_set('UTC');

use PaymentRails\Configuration;
use PHPUnit\Framework\TestCase;

class Setup extends TestCase
{
    public function __construct()
    {
        self::doSetup();
    }

    public static function doSetup()
    {
        Configuration::reset();

        Configuration::environment('development');
        Configuration::publicKey('integration_public_key');
        Configuration::privateKey('integration_private_key');
    }
}
