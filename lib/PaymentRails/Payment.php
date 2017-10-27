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
     * Return all of the Payments
     *
     * @throws Exception\NotFound
     * @return Iterator of Recipient[]
     */
    public static function all($params)
    {
        return Configuration::gateway()->payments()->search([]);
    }

    /**
     * Search payments
     * 
     * @param mixed $params
     * @throws Exception\NotFound
     * @return Iterator of Recipient[]
     */
    public static function search($params)
    {
        return Configuration::gateway()->payments()->search($params);
    }

    /**
     *
     * @param int $id
     * @throws Exception\NotFound
     * @return Recipient
     */
    public static function find($id)
    {
        return Configuration::gateway()->recipient()->find($id);
    }

    /**
     * Create a new recipient
     */
    public static function create($attrib) {
        return Configuration::gateway()->recipient()->create($attrib);
    }

    /**
     * Create a new recipient
     */
    public static function update($id, $attrib) {
        return Configuration::gateway()->recipient()->update($id, $attrib);
    }

    /**
     * Create a new recipient
     */
    public static function delete($id) {
        return Configuration::gateway()->recipient()->delete($id);
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
