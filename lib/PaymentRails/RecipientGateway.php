<?php
namespace PaymentRails;

use InvalidArgumentException;

/**
 * PaymentRails Recipient processor
 * Creates and manages transactions
 *
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Recipient, see {@link http://docs.paymentrails.com/#recipients}
 *
 * @package    PaymentRails
 * @category   Resources
 */

class RecipientGateway
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
     * For more detailed information and examples, see {@link http://docs.paymentrails.com/#recipients}
     *
     * @param mixed $query search query
     * @param array $options options such as page number
     * @return ResourceCollection
     * @throws InvalidArgumentException
     */
    public function search($query)
    {
        $response = $this->_http->get('/v1/recipients', $query);

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $query
            ];

            $items = array_map(function ($item) {
                return Recipient::factory($item);
            }, $response['recipients']);

            return new ResourceCollection($response, $items, $pager);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    /**
     * Fetch a recipient by ID
     */
    public function find($id) {
        $response = $this->_http->get('/v1/recipients/' . $id, null);

        if ($response['ok']) {
            return Recipient::factory($response['recipient']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function create($attrib) {
        $response = $this->_http->post('/v1/recipients', $attrib);
        if ($response['ok']) {
            return Recipient::factory($response['recipient']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($id, $attrib) {
        $response = $this->_http->patch('/v1/recipients/' . $id, $attrib);
        if ($response['ok']) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($id) {
        $response = $this->_http->delete('/v1/recipients/' . $id);
        if ($response) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function tax($id) {
        $response = $this->_http->get('/v1/recipients/' . $id . '/tax');
        if ($response) {
            return $response;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

}

class_alias('PaymentRails\RecipientGateway', 'PaymentRails_RecipientGateway');
