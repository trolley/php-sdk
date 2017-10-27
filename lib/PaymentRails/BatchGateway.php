<?php
namespace PaymentRails;

use InvalidArgumentException;

/**
 * PaymentRails Batch processor
 * Creates and manages batches
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Batch, see {@link http://docs.paymentrails.com/#create-a-batch}
 *
 * @package    PaymentRails
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
     * For more detailed information and examples, see {@link http://docs.paymentrails.com/#create-a-batch}
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
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function update($id, $attrib) {
        $response = $this->_http->patch('/v1/batches/' . $id, $attrib);
        if ($response['ok']) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function delete($id) {
        $response = $this->_http->delete('/v1/batches/' . $id);
        if ($response['ok']) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function summary($id) {
        $response = $this->_http->get('/v1/batches/' . $id . '/summary');
        if ($response['ok']) {
            return BatchSummary::factory($response['batchSummary']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function generateQuote($id) {
        $response = $this->_http->post('/v1/batches/' . $id . '/generate-quote');
        if ($response['ok']) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function startProcessing($id) {
        $response = $this->_http->post('/v1/batches/' . $id . '/start-processing');
        if ($response['ok']) {
            return true;
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function payments($batchId, $page = 0) {
        return $this->paymentsInternal([
            "batchId" => $batchId,
            "page" => $page,
        ]);
    }

    public function paymentsInternal($params) {
        $response = $this->_http->get('/v1/batches/' . $params['batchId'] . '/payments', [
            "page" => $params["page"],
        ]);
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
        } else {
            throw new Exception\DownForMaintenance();
        }
    }
}

class_alias('PaymentRails\BatchGateway', 'PaymentRails_BatchGateway');
