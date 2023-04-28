<?php
namespace Trolley;

use InvalidArgumentException;

/**
 * Trolley Offline Payment processor
 * Creates and manages transactions
 *
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Offline Payments, see {@link https://docs.trolley.com/api/#create-an-offline-payment}
 *
 * @package    Trolley
 * @category   Resources
 */

class OfflinePaymentGateway
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
     * For more detailed information and examples, see {@link https://docs.trolley.com/api/#offline-payments}
     *
     * @param mixed $query search query
     * @param array $options options such as page number
     * @return ResourceCollection
     * @throws InvalidArgumentException
     */
    public function search($query)
    {
        if (isset($query["recipientId"])) {
          $response = $this->_http->get('/v1/recipients/'.$query["recipientId"].'/offlinePayments', $query);
        } else {
          $response = $this->_http->get('/v1/offline-payments', $query);
        }

        if ($response['ok']) {
            $pager = [
                'object' => $this,
                'method' => 'search',
                'methodArgs' => $query
            ];

            $items = array_map(function ($item) {
                return OfflinePayment::factory($item);
            }, $response['offlinePayments']);

            return new ResourceCollection($response, $items, $pager);
        } else if ($response['errors']){
            throw new Exception\Standard($response['errors']);
        } else {
            throw new Exception\DownForMaintenance();
        }
    }

    public function create($recipientId, $offlinePaymentBody) {
      $response = $this->_http->post('/v1/recipients/' . $recipientId . '/offlinePayments', $offlinePaymentBody);
      if ($response['ok']) {
          return OfflinePayment::factory($response['offlinePayment']);
      } else if ($response['errors']){
        throw new Exception\Standard($response['errors']);
      } else {
          throw new Exception\DownForMaintenance();
      }
    }

    public function update($recipientId, $offlinePaymentId, $offlinePaymentBody) {
      $response = $this->_http->patch('/v1/recipients/' . $recipientId . '/offlinePayments/' . $offlinePaymentId, $offlinePaymentBody);
      if ($response['ok']) {
          return true;
      } else if ($response['errors']){
        throw new Exception\Standard($response['errors']);
      } else {
          throw new Exception\DownForMaintenance();
      }
    }

    public function delete($recipientId, $offlinePaymentId) {
      $response = $this->_http->delete('/v1/recipients/' . $recipientId . '/offlinePayments/' . $offlinePaymentId);
      if ($response['ok']) {
          return true;
      } else if ($response['errors']){
        throw new Exception\Standard($response['errors']);
      } else {
          throw new Exception\DownForMaintenance();
      }
    }

    /**
     * generic method for validating incoming gateway responses
     *
     * creates a new Transaction object and encapsulates
     * it inside a Result\Successful object, or
     * encapsulates a Errors object inside a Result\Error
     * alternatively, throws an Unexpected exception if the response is invalid.
     *
     * @ignore
     * @param array $response gateway response values
     * @return Result\Successful|Result\Error
     * @throws Exception\Unexpected
     */
    private function _verifyGatewayResponse($response)
    {
        if (isset($response['transaction'])) {
            // return a populated instance of Transaction
            return new Result\Successful(
                    Transaction::factory($response['transaction'])
            );
        } else if (isset($response['apiErrorResponse'])) {
            return new Result\Error($response['apiErrorResponse']);
        } else {
            throw new Exception\Unexpected(
            "Expected transaction or apiErrorResponse"
            );
        }
    }
}

class_alias('Trolley\OfflinePaymentGateway', 'Trolley_OfflinePaymentGateway');
