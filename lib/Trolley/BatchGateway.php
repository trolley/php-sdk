<?php
namespace Trolley;

use InvalidArgumentException;

/**
 * Trolley Batch processor
 * Creates and manages batches
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Batch, see {@link https://docs.trolley.com/api/#create-a-batch}
 *
 * @package    Trolley
 * @category   Resources
 */
class BatchGateway
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
     * For more detailed information and examples, see {@link https://docs.trolley.com/api/#create-a-batch}
     *
     * @param mixed $query search query
     * @param array $options options such as page number
     * @return ResourceCollection
     * @throws InvalidArgumentException
     */
    public function search($query)
    {
        $response = $this->_http->get('/v1/batches', $query);

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $query
            ];

            $items = array_map(function ($item) {
                return Batch::factory($item);
            }, $response['batches']);

            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    /**
     * Fetch a Batch by ID
     */
    public function find($id) {
        $response = $this->_http->get('/v1/batches/' . $id, null);

        if ($response['ok']) {
            return Batch::factory($response['batch']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function create($attrib, $payments = []) {
        $copy = $attrib;
        if ($payments) {
            $copy['payments'] = $payments;
        }
        $response = $this->_http->post('/v1/batches', $copy);
        if ($response['ok']) {
            return Batch::factory($response['batch']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($batchId, $attrib) {
        $response = $this->_http->patch('/v1/batches/' . $batchId, $attrib);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($batchId) {
        $response = $this->_http->delete('/v1/batches/' . $batchId);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function deleteMultiple($batchIds) {
        $response = $this->_http->delete('/v1/batches/', null, $batchIds);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function summary($batchId) {
        $response = $this->_http->get('/v1/batches/' . $batchId . '/summary');
        if ($response['ok']) {
            return BatchSummary::factory($response['batchSummary']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function generateQuote($batchId) {
        $response = $this->_http->post('/v1/batches/' . $batchId . '/generate-quote');
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function startProcessing($batchId) {
        $response = $this->_http->post('/v1/batches/' . $batchId . '/start-processing');
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function createPayment($batchId, $payment) {
        $response = $this->_http->post('/v1/batches/' . $batchId . '/payments', $payment);
        if ($response['ok']) {
            return Payment::factory($response['payment']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function findPayment($batchId, $paymentId) {
        $response = $this->_http->get('/v1/batches/' . $batchId . '/payments/' . $paymentId);
        if ($response['ok']) {
            return Payment::factory($response['payment']);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function updatePayment($batchId, $paymentId, $params) {
        $response = $this->_http->patch('/v1/batches/' . $batchId . '/payments/' . $paymentId, $params);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function deletePayment($batchId, $paymentId) {
        $response = $this->_http->delete('/v1/batches/' . $batchId . '/payments/' . $paymentId);
        if ($response['ok']) {
            return true;
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function payments($batchId, $params = []) {
        return $this->paymentsInternal(
            array_merge(['batchId' => $batchId], $params)
        );
    }

    public function paymentsInternal($params) {
        $response = $this->_http->get('/v1/batches/' . $params['batchId'] . '/payments', $params);
        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'paymentsInternal',
                'methodArgs' => $params,
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

class_alias('Trolley\BatchGateway', 'Trolley_BatchGateway');
