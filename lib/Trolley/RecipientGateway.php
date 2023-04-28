<?php
namespace Trolley;

use InvalidArgumentException;

/**
 * Trolley Recipient processor
 * Creates and manages transactions
 *
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Recipient, see {@link https://docs.trolley.com/api/#recipients}
 *
 * @package    Trolley
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
     * For more detailed information and examples, see {@link https://docs.trolley.com/api/#recipients}
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
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
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
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function create($attrib) {
        $response = $this->_http->post('/v1/recipients', $attrib);
        if ($response['ok']) {
            return Recipient::factory($response['recipient']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($id, $attrib) {
        $response = $this->_http->patch('/v1/recipients/' . $id, $attrib);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
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

    public function deleteMultiple($ids) {
        $response = $this->_http->delete('/v1/recipients/', null, $ids);
        if ($response) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function getAllLogs($id) {
        $response = $this->_http->get("/v1/recipients/{$id[0]}/logs", null);
        if ($response["ok"]) {
            $pager = [
                'object' => $this,
                'method' => 'getAllLogs',
                'methodArgs' => $id[0]
            ];

            $items = array_map(function ($item) {
                return RecipientLogs::factory($item);
            }, $response['recipientLogs']);

            return new ResourceCollection($response, $items, $pager);
        } else if($response["errors"]){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    /**
     * Returns a ResourceCollection of all payments belonging to a recipient.
     *
     * For more detailed information and examples, see {@link https://docs.trolley.com/api/#retrieve-all-payments}
     *
     * @param string $recipientId of the recipient whose payments need to be fetched
     * @return ResourceCollection
     * @throws Standard
     * @throws DownForMaintenance
     */
    public function getAllPayments($recipientId)
    {
        $response = $this->_http->get('/v1/recipients/'.$recipientId.'/payments');

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $recipientId
            ];

            $items = array_map(function ($item) {
                return Payment::factory($item);
            }, $response['payments']);

            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\RecipientGateway', 'Trolley_RecipientGateway');
