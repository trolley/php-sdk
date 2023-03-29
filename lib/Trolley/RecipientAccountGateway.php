<?php
namespace Trolley;

use InvalidArgumentException;

/**
 * Trolley RecipientAccount processor
 * Creates and manages bank accounts
 *
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on RecipientAccounts, see {@link https://docs.trolley.com/api/#recipients-accounts}
 *
 * @package    Trolley
 * @category   Resources
 */
class RecipientAccountGateway
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
    public function all($recipientId)
    {
        $response = $this->_http->get('/v1/recipients/' . $recipientId . '/accounts');

        if ($response['ok']) {
            return array_map(function ($item) {
                return RecipientAccount::factory($item);
            }, $response['accounts']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    /**
     * Fetch a recipient by ID
     */
    public function find($recipientId, $accountId) {
        $response = $this->_http->get('/v1/recipients/' . $recipientId . '/accounts/' . $accountId);

        if ($response['ok']) {
            return RecipientAccount::factory($response['account']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function create($recipientId, $attrib) {
        $response = $this->_http->post('/v1/recipients/' . $recipientId . '/accounts', $attrib);
        if ($response['ok']) {
            return RecipientAccount::factory($response['account']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($recipientId, $accountId, $attrib) {
        $response = $this->_http->patch('/v1/recipients/' . $recipientId . '/accounts/' . $accountId, $attrib);
        if ($response['ok']) {
            return Recipient::factory($response['account']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($recipientId, $accountId) {
        $response = $this->_http->delete('/v1/recipients/' . $recipientId . '/accounts/' . $accountId);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('Trolley\RecipientAccountGateway', 'Trolley_RecipientAccountGateway');
