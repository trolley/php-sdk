<?php
namespace Trolley;
use Dotenv\Dotenv;

/**
 *
 * Configuration registry
 *
 * @package    Trolley
 * @subpackage Utility
 */
class Configuration
{
    public static $global;

    private $_environment = null;
    private $_merchantId = null;
    private $_publicKey = null;
    private $_privateKey = null;
    private $_clientId = null;
    private $_clientSecret = null;
    private $_accessToken = null;
    private $_proxyHost = null;
    private $_proxyPort = null;
    private $_proxyType = null;
    private $_proxyUser = null;
    private $_proxyPassword = null;
    private $_timeout = 120;
    private $_sslVersion = null;
    private $_acceptGzipEncoding = true;

    /**
     * Trolley API version to use
     * @access public
     */
    const API_VERSION =  1;

    public function __construct($attribs = [])
    {
        foreach ($attribs as $kind => $value) {
            if ($kind == 'publicKey') {
                $this->_publicKey = $value;
            }
            if ($kind == 'privateKey') {
                $this->_privateKey = $value;
            }
        }
    }

    /**
     * resets configuration to default
     * @access public
     */
    public static function reset()
    {
        self::$global = new Configuration();
    }

    public static function gateway()
    {
        return new Gateway(self::$global);
    }

    public static function environment($value=null)
    {
        self::$global->setEnvironment($value);
    }

    public static function publicKey($value=null)
    {
        if (empty($value)) {
            return self::$global->getPublicKey();
        }
        self::$global->setPublicKey($value);
    }

    public static function privateKey($value=null)
    {
        if (empty($value)) {
            return self::$global->getPrivateKey();
        }
        self::$global->setPrivateKey($value);
    }

    /**
     * Sets or gets the read timeout to use for making requests.
     *
     * @param integer $value If provided, sets the read timeout
     * @return integer The read timeout used for connecting to Trolley
     */
    public static function timeout($value=null)
    {
        if (empty($value)) {
            return self::$global->getTimeout();
        }
        self::$global->setTimeout($value);
    }

    /**
     * Sets or gets the SSL version to use for making requests. See
     * http://php.net/manual/en/function.curl-setopt.php for possible
     * CURLOPT_SSLVERSION values.
     *
     * @param integer $value If provided, sets the SSL version
     * @return integer The SSL version used for connecting to Trolley
     */
    public static function sslVersion($value=null)
    {
        if (empty($value)) {
            return self::$global->getSslVersion();
        }
        self::$global->setSslVersion($value);
    }

    /**
     * Sets or gets the proxy host to use for connecting to Trolley
     *
     * @param string $value If provided, sets the proxy host
     * @return string The proxy host used for connecting to Trolley
     */
    public static function proxyHost($value = null)
    {
        if (empty($value)) {
            return self::$global->getProxyHost();
        }
        self::$global->setProxyHost($value);
    }

    /**
     * Sets or gets the port of the proxy to use for connecting to Trolley
     *
     * @param string $value If provided, sets the port of the proxy
     * @return string The port of the proxy used for connecting to Trolley
     */
    public static function proxyPort($value = null)
    {
        if (empty($value)) {
            return self::$global->getProxyPort();
        }
        self::$global->setProxyPort($value);
    }

    /**
     * Sets or gets the proxy type to use for connecting to Trolley. This value
     * can be any of the CURLOPT_PROXYTYPE options in PHP cURL.
     *
     * @param string $value If provided, sets the proxy type
     * @return string The proxy type used for connecting to Trolley
     */
    public static function proxyType($value = null)
    {
        if (empty($value)) {
            return self::$global->getProxyType();
        }
        self::$global->setProxyType($value);
    }

    /**
     * Specifies whether or not a proxy is properly configured
     *
     * @return bool true if a proxy is configured properly, false if not
     */
    public static function isUsingProxy()
    {
        $proxyHost = self::$global->getProxyHost();
        $proxyPort = self::$global->getProxyPort();
        return !empty($proxyHost) && !empty($proxyPort);
    }

    public static function proxyUser($value = null)
    {
        if (empty($value)) {
            return self::$global->getProxyUser();
        }
        self::$global->setProxyUser($value);
    }

    public static function proxyPassword($value = null)
    {
        if (empty($value)) {
            return self::$global->getProxyPassword();
        }
        self::$global->setProxyPassword($value);
    }

    /**
     * Specified whether or not a username and password have been provided for
     * use with an authenticated proxy
     *
     * @return bool true if both proxyUser and proxyPassword are present
     */
    public static function isAuthenticatedProxy()
    {
        $proxyUser = self::$global->getProxyUser();
        $proxyPwd = self::$global->getProxyPassword();
        return !empty($proxyUser) && !empty($proxyPwd);
    }

    /**
     * Specify if the HTTP client is able to decode gzipped responses.
     *
     * @param bool $value If true, will send an Accept-Encoding header with a gzip value. If false, will not send an Accept-Encoding header with a gzip value.
     * @return bool true if an Accept-Encoding header with a gzip value will be sent, false if not
     */
    public static function acceptGzipEncoding($value = null)
    {
        if (is_null($value)) {
            return self::$global->getAcceptGzipEncoding();
        }
        self::$global->setAcceptGzipEncoding($value);
    }

    public static function assertGlobalHasAccessTokenOrKeys()
    {
        self::$global->assertHasAccessTokenOrKeys();
    }

    public function assertHasAccessTokenOrKeys()
    {
        if (empty($this->_accessToken)) {
            if (empty($this->_publicKey)) {
                throw new Exception\Configuration('Trolley\\Configuration::publicKey needs to be set.');
            } else if (empty($this->_privateKey)) {
                throw new Exception\Configuration('Trolley\\Configuration::privateKey needs to be set.');
            }
        }
    }

    public function assertHasClientCredentials()
    {
        $this->assertHasClientId();
        $this->assertHasClientSecret();
    }

    public function assertHasClientId()
    {
        if (empty($this->_clientId)) {
            throw new Exception\Configuration('clientId needs to be passed to Trolley\\Gateway.');
        }
    }

    public function assertHasClientSecret()
    {
        if (empty($this->_clientSecret)) {
            throw new Exception\Configuration('clientSecret needs to be passed to Trolley\\Gateway.');
        }
    }

    public function getEnvironment()
    {
        return $this->_environment;
    }

    /**
     * Do not use this method directly. Pass in the environment to the constructor.
     */
    public function setEnvironment($value)
    {
        $this->_environment = $value;
    }

    public function getPublicKey()
    {
        return $this->_publicKey;
    }

    public function getClientId()
    {
        return $this->_clientId;
    }

    /**
     * Do not use this method directly. Pass in the publicKey to the constructor.
     */
    public function setPublicKey($value)
    {
        $this->_publicKey = $value;
    }

    public function getPrivateKey()
    {
        return $this->_privateKey;
    }

    public function getClientSecret()
    {
        return $this->_clientSecret;
    }

    /**
     * Do not use this method directly. Pass in the privateKey to the constructor.
     */
    public function setPrivateKey($value)
    {
        $this->_privateKey = $value;
    }

    private function setProxyHost($value)
    {
        $this->_proxyHost = $value;
    }

    public function getProxyHost()
    {
        return $this->_proxyHost;
    }

    private function setProxyPort($value)
    {
        $this->_proxyPort = $value;
    }

    public function getProxyPort()
    {
        return $this->_proxyPort;
    }

    private function setProxyType($value)
    {
        $this->_proxyType = $value;
    }

    public function getProxyType()
    {
        return $this->_proxyType;
    }

    private function setProxyUser($value)
    {
        $this->_proxyUser = $value;
    }

    public function getProxyUser()
    {
        return $this->_proxyUser;
    }

    private function setProxyPassword($value)
    {
        $this->_proxyPassword = $value;
    }

    public function getProxyPassword()
    {
        return $this->_proxyPassword;
    }

    private function setTimeout($value)
    {
        $this->_timeout = $value;
    }

    public function getTimeout()
    {
        return $this->_timeout;
    }

    private function setSslVersion($value)
    {
        $this->_sslVersion = $value;
    }

    private function getSslVersion()
    {
        return $this->_sslVersion;
    }

    private function getAcceptGzipEncoding()
    {
        return $this->_acceptGzipEncoding;
    }

    private function setAcceptGzipEncoding($value)
    {
        $this->_acceptGzipEncoding = $value;
    }

    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function isAccessToken()
    {
        return !empty($this->_accessToken);
    }

    public function isClientCredentials()
    {
        return !empty($this->_clientId);
    }
    /**
     * returns the base Trolley gateway URL based on config values
     *
     * @access public
     * @param none
     * @return string Trolley gateway URL
     */
    public function baseUrl()
    {		
		return $this->serverName();
    }

    /**
     * returns the port number depending on environment
     *
     * @access public
     * @param none
     * @return int portnumber
     */
    public function portNumber()
    {
        if ($this->sslOn()) {
            return 443;
        }
        return getenv("GATEWAY_PORT") ? getenv("GATEWAY_PORT") : 3000;
    }

    /**
     * returns http protocol depending on environment
     *
     * @access public
     * @param none
     * @return string http || https
     */
    public function protocol()
    {
        return $this->sslOn() ? 'https' : 'http';
    }

    /**
     * returns gateway server name depending on environment
     *
     * @access public
     * @param none
     * @return string server domain name
     */
    public function serverName()
    {
        switch($this->_environment) {
            case 'development':
                $dotenv = Dotenv::createImmutable(__DIR__.DIRECTORY_SEPARATOR. '..' .DIRECTORY_SEPARATOR. '..');
                $dotenv->load();
                $serverName = $_ENV['SERVER_URL'];
                break;
            default:
                $serverName = 'https://api.trolley.com';
                break;
           }
        return $serverName;
    }

    /**
     * returns boolean indicating SSL is on or off for this session,
     * depending on environment
     *
     * @access public
     * @param none
     * @return boolean
     */
    public function sslOn()
    {
        switch($this->_environment) {
            case 'development':
                $ssl = false;
                break;
            default:
                $ssl = true;
                break;
           }
           if (substr($this->_environment, 0, strlen('localhost')) === 'localhost') {
               $ssl = false;
           }
   
          return $ssl;
    }

    /**
     * log message to default logger
     *
     * @param string $message
     *
     */
    public function logMessage($message)
    {
        error_log('[Trolley] ' . $message);
    }
}

Configuration::reset();
class_alias('Trolley\Configuration', 'Trolley_Configuration');
