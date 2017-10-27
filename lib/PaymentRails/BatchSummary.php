<?php
namespace PaymentRails;

/**
 * PaymentRails BatchSummary Data
 * PHP Version 5
 * Creates and manages batches of payments
 *
 * @package   PaymentRails
 *
 */
class BatchSummary extends Base
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
        "methods" => "",
    ];

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
            "methods",
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

class_alias('PaymentRails\BatchSummary', 'PaymentRails_BatchSummary');
