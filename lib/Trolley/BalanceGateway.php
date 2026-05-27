<?php
namespace Trolley;

use InvalidArgumentException;

/**
 * Trolley Balance processor
 * Gets balances
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Balance, see {@link https://docs.trolley.com/api/#balances}
 *
 * @package    Trolley
 * @category   Resources
 */
class BalanceGateway
{
    private $_gateway;
    private $_config;
    private $_http;

    public function __construct($gateway)
    {
        $this->_gateway = $gateway;
        $this->_config = $gateway->config;
        $this->_config->assertHasAccessTokenOrKeys();
        $this->_http = new Http($gateway->config);
    }

    /**
     * Returns a ResourceCollection of transactions matching the search query.
     *
     * If <b>query</b> is a string, the search will be a basic search.
     * If <b>query</b> is a hash, the search will be an advanced search.
     * For more detailed information and examples, see {@link https://docs.trolley.com/api/#balances}
     *
     * @param mixed $query search query
     * @param array $options options such as page number
     * @return ResourceCollection
     * @throws InvalidArgumentException
     */
    public function search($params, $query)
    {
        $path = $params ? "/v1/balances/{$params}" : '/v1/balances';
        $response = $this->_http->get($path, $query);
        

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'searchPage',
                'methodArgs' => array_merge(['params' => $params], $query)
            ];

            $items = array_map(function ($item) {
                return Balance::factory($item);
            }, $response['balances']);

            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function searchPage($query)
    {
        $params = isset($query['params']) ? $query['params'] : '';
        unset($query['params']);
        return $this->search($params, $query);
    }

    public function all($query = [])
    {
        $response = $this->_http->get('/v1/balances', $query);
        return $this->balancesCollection($response, 'all', $query);
    }

    public function paymentrails($query = [])
    {
        $response = $this->_http->get('/v1/balances/paymentrails', $query);
        return $this->balancesCollection($response, 'paymentrails', $query);
    }

    public function paypal($query = [])
    {
        $response = $this->_http->get('/v1/balances/paypal', $query);
        return $this->balancesCollection($response, 'paypal', $query);
    }

    private function balancesCollection($response, $method, $query)
    {
        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => $method,
                'methodArgs' => $query
            ];

            $items = array_map(function ($item) {
                return Balance::factory($item);
            }, $response['balances']);
            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']) {
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\BalanceGateway', 'Trolley_BalanceGateway');
