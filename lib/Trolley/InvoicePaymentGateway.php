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

class InvoicePaymentGateway
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
        $response = $this->_http->post('/v1/invoices/payment/create/', $params);
        if ($response['ok']) {
            return InvoicePayment::factoryArray($response['invoicePayment']['invoicePayments']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($ids) {
        $response = $this->_http->post('/v1/invoices/payment/update', $ids);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
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
        $response = $this->_http->post('/v1/invoices/payment/search/', $params);

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $params
            ];

            $items = array_map(function ($item) {
                return InvoicePayment::factory($item);
            }, $response['invoicePayments']);

            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($params) {
        $response = $this->_http->post('/v1/invoices/payment/delete/', $params);
        if ($response["ok"]) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\InvoicePaymentGateway', 'Trolley_InvoicePaymentGateway');
