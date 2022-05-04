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

        Configuration::environment('production');
        Configuration::publicKey('ASC7AsydNKAKBB5BNEVFVZ0P');
        Configuration::privateKey('4vapebxbpq26gmk7a2zdj837u0qn24ufynqnnjfq');
    }
}
