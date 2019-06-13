<?php
namespace PaymentRails;

use finfo;

/**
 * PaymentRails HTTP Client
 * processes Http requests using curl
 */
class Http
{
    protected $_config;
    private $_useClientCredentials = false;

    public function __construct($config)
    {
        $this->_config = $config;
    }

    /**
     * Encode the query string using ',' for array item separation
     */
    private function _encodeQuery($path, $query) {
        if (!$query) {
            return $path;
        }
        $output = '';
        foreach ($query as $key => $value) {
            $output .= (strlen($output) == 0 ? '?' : '&') . urlencode($key) . '=';
            if (is_array($value)) {
                $output .= join(',', array_map(urlencode, $value));
            } else {
                $output .= urlencode($value);
            }
        }
        return $path . $output;
    }

        /**
     * throws an exception based on the type of error
     * @param string $statusCode HTTP status code to throw exception from
     * @param null|string $message
     * @throws Exception multiple types depending on the error
     * @return void
     */
    private function _throwStatusCodeException($response, $message=null)
    {
        switch($response['status']) {
        case 400:
            // throw new Exception\Malformed();
            throw new Exception\Standard($response['body']);
            break;
        case 401:
            // throw new Exception\Authentication();
            throw new Exception\Standard($response['body']);
            break;
        case 403:
            throw new Exception\Authorization($message);
            break;
        case 404:
            // throw new Exception\NotFound();
            throw new Exception\Standard($response['body']);
            break;
        case 429:
            throw new Exception\TooManyRequests();
            break;
        case 500:
            throw new Exception\ServerError();
            break;
        case 503:
            throw new Exception\DownForMaintenance();
            break;
        default:
            throw new Exception\Unexpected('Unexpected HTTP_RESPONSE #' . $response['status']);
            break;
        }
    }

    public function delete($path, $query = null, $params = null)
    {
        $response = $this->_doRequest('DELETE', $this->_encodeQuery($path, $query), $params);
        $responseCode = $response['status'];
        if ($responseCode === 200 || $responseCode === 204) {
            return json_decode($response['body'], true);
        } else {
            $this->_throwStatusCodeException($response);
        }
    }

    public function get($path, $query = null)
    {
        $response = $this->_doRequest('GET', $this->_encodeQuery($path, $query));
        if ($response['status'] === 200) {
            return json_decode($response['body'], true);
        } else {
            $this->_throwStatusCodeException($response);
        }
    }

    public function post($path, $params = null)
    {
        $response = $this->_doRequest('POST', $path, $params ? json_encode($params) : null);
        $responseCode = $response['status'];
        if ($responseCode === 200 || $responseCode === 201) {
            return json_decode($response['body'], true);
        } else {
            $this->_throwStatusCodeException($response);
        }
    }

    public function patch($path, $params = null)
    {
        $response = $this->_doRequest('PATCH', $path, $params ? json_encode($params) : null);
        $responseCode = $response['status'];
        if ($responseCode === 200 || $responseCode === 201 || $responseCode === 422 || $responseCode == 400) {
            return json_decode($response['body'], true);
        } else {
            $this->_throwStatusCodeException($response);
        }
    }

    private function _getHeaders()
    {
        return [
            'Accept: application/json',
        ];
    }

    private function _doRequest($httpVerb, $path, $requestBody = null)
    {
        return $this->_doUrlRequest($httpVerb, $this->_config->baseUrl() . $path, $path, $requestBody);
    }

    public function _doUrlRequest($httpVerb, $url, $path, $requestBody = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->_config->timeout());
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $httpVerb);
        curl_setopt($curl, CURLOPT_URL, $url);

        if ($this->_config->acceptGzipEncoding()) {
            curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
        }
        if ($this->_config->sslVersion()) {
            curl_setopt($curl, CURLOPT_SSLVERSION, $this->_config->sslVersion());
        }

        $timestamp = time();
        $message = join("\n", [$timestamp, $httpVerb, $path, $requestBody ? $requestBody : '', '']);

        $signature = hash_hmac("sha256", $message, $this->_config->getPrivateKey());

        $headers = $this->_getHeaders($curl);
        $headers[] = "Authorization: prsign " . $this->_config->getPublicKey() . ":" . $signature;
        $headers[] = "X-PR-Timestamp: " . $timestamp;
        $headers[] = 'User-Agent: PaymentRails PHP Library version=' . Version::get();

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if (!empty($requestBody)) {
            $headers[] = "Content-Type: application/json";
            curl_setopt($curl, CURLOPT_POSTFIELDS, $requestBody);
        }

        if ($this->_config->isUsingProxy()) {
            $proxyHost = $this->_config->getProxyHost();
            $proxyPort = $this->_config->getProxyPort();
            $proxyType = $this->_config->getProxyType();
            $proxyUser = $this->_config->getProxyUser();
            $proxyPwd= $this->_config->getProxyPassword();
            curl_setopt($curl, CURLOPT_PROXY, $proxyHost . ':' . $proxyPort);
            if (!empty($proxyType)) {
                curl_setopt($curl, CURLOPT_PROXYTYPE, $proxyType);
            }
            if ($this->_config->isAuthenticatedProxy()) {
                curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxyUser . ':' . $proxyPwd);
            }
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error_code = curl_errno($curl);
        $error = curl_error($curl);

        if ($error_code == 28 && $httpStatus == 0) {
            throw new Exception\Timeout();
        }

        curl_close($curl);
        if ($this->_config->sslOn()) {
            if ($httpStatus == 0) {
                throw new Exception\SSLCertificate($error, $error_code);
            }
        } else if ($error_code) {
            throw new Exception\Connection($error, $error_code);
        }

        return ['status' => $httpStatus, 'body' => $response];
    }
}

class_alias('PaymentRails\Http', 'PaymentRails_Http');
