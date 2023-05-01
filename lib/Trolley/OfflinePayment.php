<?php
namespace Trolley;

/**
 * Trolley Payment Module
 * PHP Version 5
 * Creates and manages Offline Payments
 *
 * @package   Trolley
 *
 */
class OfflinePayment extends Base
{
    /**
     * @access protected
     * @var array registry of customer data
     */
    protected $_attributes = [
        "id" => "",
        "recipientId" => "",
        "amount" => "",
        "currency" => "",
        "withholdingAmount" => "",
        "withholdingCurrency" => "",
        "equivalentWithholdingAmount" => "",
        "equivalentWithholdingCurrency" => "",
        "externalId" => "",
        "memo" => "",
        "tags" => "",
        "category" => "",
        "processedAt" => "",
        "enteredAmount" => "",
        "updatedAt" => "",
        "createdAt" => "",
        "deletedAt" => "",
    ];

    /**
     * Creates an offline payment
     * 
     * @return OfflinePayment
     */
    public static function create($recipientId, $params)
    {
      return Configuration::gateway()->offlinePayments()->create($recipientId, $params);;
    }

    /**
     * Update an offline payment
     *
     * @param string $recipientId
     * @param string $offlinePaymentId
     * @param mixed $params
     * @throws Exception\NotFound
     * @return boolean
     */
    public static function update($recipientId, $offlinePaymentId, $params)
    {
        return Configuration::gateway()->offlinePayments()->update($recipientId, $offlinePaymentId, $params);
    }

    /**
     * Delete an offline payment
     *
     * @param string $recipientId
     * @param string $offlinePaymentId
     * @throws Exception\NotFound
     * @return boolean
     */
    public static function delete($recipientId, $offlinePaymentId)
    {
        return Configuration::gateway()->offlinePayments()->delete($recipientId, $offlinePaymentId);
    }
	
	/**
	 * Returns searched Offline Payments.
     *
     * @param mixed $params[
     *      "page",     (optional)
     *      "pageSize", (optional)
     *      "search"    (optional)
     *  ]
     * 
     * @throws Exception\NotFound
     * @return Iterator of OfflinePayment[]
     */
    public static function search($params = [])
    {
        return Configuration::gateway()->offlinePayments()->search($params);
    }

    /**
	 * Returns all Offline Payments.
     *
     * @param integer $page
     * @param integer $pageSize
     * @throws Exception\NotFound
     * @return Iterator of OfflinePayment[]
     */
    public static function all($page = 1, $pageSize = 10)
    {
        return Configuration::gateway()->offlinePayments()->search([
            "page" => $page,
            "pageSize" => $pageSize
        ]);
    }

    /**
     * sets instance properties from an array of values
     *
     * @ignore
     * @access protected
     * @param array $transactionAttribs array of transaction data
     * @return void
     */
    protected function _initialize($attributes) {
        $fields = [
            "id",
            "recipientId",
            "amount",
            "currency",
            "withholdingAmount",
            "withholdingCurrency",
            "equivalentWithholdingAmount",
            "equivalentWithholdingCurrency",
            "externalId",
            "memo",
            "tags",
            "category",
            "processedAt",
            "enteredAmount",
            "updatedAt",
            "createdAt",
            "deletedAt",
        ];

        foreach ($fields as $field) {
            if (isset($attributes[$field])) {
                $this->_set($field, $attributes[$field]);
            }
        }
    }


   /**
     *  factory method: returns an instance of Transaction
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Transaction
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }
}

class_alias('Trolley\OfflinePayment', 'Trolley_OfflinePayment');
