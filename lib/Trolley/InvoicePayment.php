<?php
namespace Trolley;
use Malformed;
/**
 * Trolley InvoicePayment module
 * PHP Version 5
 * Creates and manages Trolley InvoicesPayment
 *
 * @package Trolley
 *
 */
class InvoicePayment extends Base
{
    /**
     * @access protected
     * @var array registry of invoice payment data
     */
    protected $_attributes = [
        "invoiceId" => "",
        "invoiceLineId" => "",
        "paymentId" => "",
        "amount" => ""
    ];

    /**
     * Create a new Invoice Payment against the $invoiceId of $invoiceLineId provided.
     * Either $invoiceId or $invoiceLineId must be provided..
     * @param array $ids array of invoiceIds or invoiceLineIds which the payment needs to be created for
     * @param string optional $batchId. If provided, the payments will be added to this batch
     */
    public static function create($ids = [], $batchId = "") {
        $params = [
            "ids" => $ids
        ];
        if($batchId){
            $params["batchId"] = $batchId;
        }
        return Configuration::gateway()->invoicePayment()->create($params);
    }

    /**
     * Update an InvoicePayment
     * @param array $ids invoiceIds, invoiceLineIds, or $paymentId of the payment which needs to be updated
     */
    public static function update($ids) {
        return Configuration::gateway()->invoicePayment()->update($ids);
    }

    /**
     * Search for invoices payments.
     * Either an invoiceId or a paymentId must be provided
     * @param array (optional) $paymentIds of the payments to search for
     * @param array (optional) $invoiceIds of the invoices whose payments are to be searched
     * @throws Exception\NotFound
     * @return Iterator of Invoice[]
     */
    public static function search($paymentIds = [], $invoiceIds = [], $page = 1, $pageSize = 10)
    {
        $params = [];
        if($paymentIds){
            $params["paymentIds"] = $paymentIds;
        }

        if($invoiceIds){
            $params["invoiceIds"] = $invoiceIds;
        }
        $params["page"] = $page;
        $params["pageSize"] = $pageSize;

        return Configuration::gateway()->invoicePayment()->search($params);
    }

    /**
     * Remove the association between a payment and an invoice. Note: if the payment is processed then this will not change the value of the payment.
     * @param string $paymentId ID of the payment which needs to be deleted.
     * @param array $lineItems Array of associated invoiceLineIds.
     */
    public static function delete($paymentId, $invoiceLineIds = []) {
        return Configuration::gateway()->invoicePayment()->delete([
            "paymentId"         => $paymentId,
            "invoiceLineIds"    => $invoiceLineIds
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
            "invoiceId",
            "invoiceLineId",
            "paymentId",
            "amount"
        ];

        foreach ($fields as $key => $field) {
            if (is_numeric($key)) {
                if (isset($attributes[$field])) {
                    $this->_set($field, $attributes[$field]);
                }
            } else {
                if (isset($attributes[$key])) {
                    $this->_set($key, call_user_func($field, $attributes[$key]));
                }
            }
            
        }
    }


   /**
     *  factory method: returns an instance of InvoicePayment
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return InvoicePayment
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    /**
     *  factory method: returns an array of InvoicePayment instances
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Array InvoicePayment
     */
    public static function factoryArray($arr)
    {
        $instances = [];
        foreach ($arr as $key => $invoicePayment) {
            $instance = new self();
            $instance->_initialize($invoicePayment);
            array_push($instances, $instance);
        }

        return $instances;
    }
}

class_alias('Trolley\InvoicePayment', 'Trolley_InvoicePayment');
