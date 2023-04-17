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

class InvoiceLineGateway
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

    public function create($params) {
        $response = $this->_http->post('/v1/invoices/create-lines/', $params);
        if ($response['ok']) {
            return Invoice::factory($response['invoice']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($params) {
        $response = $this->_http->post('/v1/invoices/update-lines', $params);
        if ($response['ok']) {
            return Invoice::factory($response['invoice']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($params) {
        $response = $this->_http->post('/v1/invoices/delete-lines/', $params);
        if ($response) {
            return Invoice::factory($response['invoice']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\InvoiceLineGateway', 'Trolley_InvoiceLineGateway');
