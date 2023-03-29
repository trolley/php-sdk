<?php
namespace Test;

// require_once __DIR__ . '/Helper.php';
require_once '../vendor/autoload.php';

date_default_timezone_set('UTC');

use Trolley\Configuration;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use \Exception;

ini_set('display_errors', '1');

class Setup extends TestCase
{
    public function __construct()
    {
        self::doSetup();
    }

    public static function doSetup()
    {
        $envFile = (__DIR__.DIRECTORY_SEPARATOR. '..');
        if(!file_exists($envFile)){
            throw new Exception('.env file not found in project root. Instructions on how to generate one from example are in README.');
        }

        $dotenv = Dotenv::createImmutable($envFile);
        $dotenv->load();

        Configuration::reset();

        Configuration::publicKey($_ENV['ACCESS_KEY']);
        Configuration::privateKey($_ENV['ACCESS_SECRET']);

        /**
         * Use environment=development if you want to use a different base URL than api.trolley.com
         * Set that URL in an .env file. Read instructions in README file on how to do this
         * */

        // Configuration::environment('development');
    }
}
