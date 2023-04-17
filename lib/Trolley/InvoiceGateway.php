<?php
namespace Trolley;

use InvalidArgumentException;

/**
 * Trolley  processor
 * Creates and manages transactions
 *
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Invoice, see {@link https://docs.trolley.com/api/#invoices}
 *
 * @package    Trolley
 * @category   Resources
 */

class InvoiceGateway
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
     * For more detailed information and examples, see {@link https://docs.trolley.com/api/#search-invoices}
     *
     * @param mixed $params search query
     * @return ResourceCollection
     * @throws InvalidArgumentException
     */
    public function search($params)
    {
        $response = $this->_http->post('/v1/invoices/search/', $params);

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $params
            ];

            $items = array_map(function ($item) {
                return Invoice::factory($item);
            }, $response['invoices']);

            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    /**
     * Fetch a Invoice by ID
     */
    public function fetch($id) {
        $response = $this->_http->post('/v1/invoices/get/', ['invoiceId' => $id]);
        if ($response['ok']) {
            return Invoice::factory($response['invoice']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function create($attrib) {
        $response = $this->_http->post('/v1/invoices/create/', $attrib);
        if ($response['ok']) {
            return Invoice::factory($response['invoice']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($attrib) {
        $response = $this->_http->post('/v1/invoices/update', $attrib);
        if ($response['ok']) {
            return Invoice::factory($response['invoice']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($id) {
        $response = $this->_http->post('/v1/invoices/delete/', $id);
        if ($response) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\InvoiceGateway', 'Trolley_InvoiceGateway');
