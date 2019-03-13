<?php
namespace PaymentRails;

/**
 * PaymentRails Payment Module
 * PHP Version 5
 * Creates and manages Payments
 *
 * @package   PaymentRails
 *
 */
class Payment extends Base
{
    /**
     * @access protected
     * @var array registry of customer data
     */
    protected $_attributes = [
        'id',
        'methodDisplay',
        'recipient',
        'status',
        'isSupplyPayment',
        'returnedAmount',
        'sourceAmount',
        'sourceCurrency',
        'targetAmount',
        'targetCurrency',
        'exchangeRate',
        'fees',
        'recipientFees',
        'fxRate',
        'memo',
        'externalId',
        'processedAt',
        'createdAt',
        'updatedAt',
        'merchantFees',
        'compliance',
        'payoutMethod',
    ];

    /**
     * Return all of the Recipient Payments
     *
     * @throws Exception\NotFound
     * @return Iterator of Payment[]
     */
    public static function all($id)
    {
        return Configuration::gateway()->payments()->search($id, []);
    }
	
	/**
	 * Returns searched Recipient payments.
     *
     * @param mixed $params
     * @throws Exception\NotFound
     * @return Iterator of Payment[]
     */
    public static function search($id, $params)
    {
        return Configuration::gateway()->payments()->search($id, $params);
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
            'id',
            'methodDisplay',
            'recipient',
            'status',
            'isSupplyPayment',
            'returnedAmount',
            'sourceAmount',
            'sourceCurrency',
            'targetAmount',
            'targetCurrency',
            'exchangeRate',
            'fees',
            'recipientFees',
            'fxRate',
            'memo',
            'externalId',
            'processedAt',
            'createdAt',
            'updatedAt',
            'merchantFees',
            'compliance',
            'payoutMethod',
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

class_alias('PaymentRails\Payment', 'PaymentRails_Payment');
