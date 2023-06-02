<?php
namespace Trolley;
use Malformed;
/**
 * Trolley Batch module
 * PHP Version 5
 * Creates and manages batches of payments
 *
 * @package   Trolley
 *
 */
class Batch extends Base
{
    /**
     * @access protected
     * @var array registry of customer data
     */
    protected $_attributes = [
        "id" => "",
        "amount" => "",
        "completedAt" => "",
        "createdAt" => "",
        "currency" => "",
        "description" => "",
        "sentAt" => "",
        "status" => "",
        "totalPayments" => "",
        "updatedAt" => "",
        "payments" => ""
    ];

    /**
     * Show all batches
     *
     * @param mixed $params
     * @param mixed $payments
     * @return Batch
     */
    public static function all()
    {
        return Configuration::gateway()->batch()->search([]);
    }

    /**
     * Search batches
     *
     * @param mixed $params
     * @param mixed $payments
     * @return Batch
     */
    public static function search($query)
    {
        return Configuration::gateway()->batch()->search($query);
    }

    /**
     * Get a specific batch
     *
     * @param mixed $batchId
     * @param mixed $payments
     * @return Batch
     */
    public static function find($batchId)
    {
        return Configuration::gateway()->batch()->find($batchId);
    }

    /**
     * Create a batch
     *
     * @param mixed $batchDescription
     * @param mixed $payments
     * @return Batch
     */
    public static function create($batchDescription, $payments = null)
    {
        return Configuration::gateway()->batch()->create($batchDescription, $payments);
    }

    /**
     * Update the batch
     *
     * @param string $batchId
     * @param mixed $params
     * @throws Exception\NotFound
     * @return boolean
     */
    public static function update($batchId, $params)
    {
        return Configuration::gateway()->batch()->update($batchId, $params);
    }

    /**
     * Delete a batch
     *
     * @param string $batchId
     * @throws Exception\NotFound
     * @return boolean
     */
    public static function delete($batchId)
    {
        return Configuration::gateway()->batch()->delete($batchId);
    }

    /**
     * Delete multiple batches
     *
     * @param array $batchIds
     * @throws Exception\NotFound
     * @return boolean
     */
    public static function deleteMultiple($batchIds)
    {
        if(!is_array($batchIds)){
            throw new Exception\Malformed("Batch::deleteMultiple() expects array parameters.");
        }

        if(count($batchIds)==0){
            throw new Exception\Malformed("array parameters is empty.");
        }

        return Configuration::gateway()->batch()->deleteMultiple(["ids" => $batchIds]);
    }

    /**
     * Get all the payments for a batch
     * 
     * @param string $batchId
     * @throws Exception\NotFound
     * @return Interator Payments
     */
    public static function payments($batchId, $params = [])
    {
        return Configuration::gateway()->batch()->payments($batchId, $params);
    }

    /**
     * Add a single payment to a batch
     * 
     * @param string $batchId
     * @param mixed $payment
     * @throws Exception\NotFound
     * @return Payment
     */
    public static function createPayment($batchId, $payment)
    {
        return Configuration::gateway()->batch()->createPayment($batchId, $payment);
    }

    /**
     * Add a single payment to a batch
     * 
     * @param string $batchId
     * @param mixed $payment
     * @throws Exception\NotFound
     * @return Payment
     */
    public static function findPayment($batchId, $paymentId)
    {
        return Configuration::gateway()->batch()->findPayment($batchId, $paymentId);
    }

    /**
     * Add a update payment to a batch
     * 
     * @param string $batchId
     * @param string $paymentId
     * @param mixed $params
     * @throws Exception\NotFound
     * @return Payment
     */
    public static function updatePayment($batchId, $paymentId, $params)
    {
        return Configuration::gateway()->batch()->updatePayment($batchId, $paymentId, $params);
    }

    /**
     * Delete a payment from a batch
     * 
     * @param string $batchId
     * @param string $paymentId
     * @throws Exception\NotFound
     * @return Payment
     */
    public static function deletePayment($batchId, $paymentId)
    {
        return Configuration::gateway()->batch()->deletePayment($batchId, $paymentId);
    }

    /**
     * Generate the Quote for this batch
     *
     * @param string $batchId
     * @throws Exception\NotFound
     * @return boolean
     */
    public static function generateQuote($batchId) {
        return Configuration::gateway()->batch()->generateQuote($batchId);
    }

    /**
     * Get the batch summary
     *
     * @param string $batchId
     * @throws Exception\NotFound
     * @return BatchSummary
     */
    public static function summary($batchId) {
        return Configuration::gateway()->batch()->summary($batchId);
    }

    /**
     * Start the batch processing
     *
     * @param string $batchId
     * @throws Exception\NotFound
     * @return BatchSummary
     */
    public static function startProcessing($batchId) {
        return Configuration::gateway()->batch()->startProcessing($batchId);
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
            "amount",
            "completedAt",
            "createdAt",
            "currency",
            "description",
            "sentAt",
            "status",
            "totalPayments",
            "updatedAt",
            "payments"  => 'Trolley\Payment::factoryArray'
        ];

        foreach ($fields as $key => $field) {
            if (is_numeric($key)) {
                if (isset($attributes[$field])) {
                    $this->_set($field, $attributes[$field]);
                }
            } else {
                if (isset($attributes[$key])) {
                    if($key === "payments"){
                        $this->_set($key, call_user_func($field, $attributes[$key]["payments"]));
                    }else{
                        $this->_set($key, call_user_func($field, $attributes[$key]));
                    }                    
                }
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

class_alias('Trolley\Batch', 'Trolley_Batch');
