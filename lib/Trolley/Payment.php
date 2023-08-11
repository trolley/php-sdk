<?php
namespace Trolley;

/**
 * Trolley Payment Module
 * PHP Version 5
 * Creates and manages Payments
 *
 * @package   Trolley
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
        'amount',
        'currency',
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
        'coverFees',
        'taxReportable',
        'checkNumber',
        'tags',
        'estimatedDeliveryAt',
        'initiatedAt',
        'returnedAt',
    ];

    /**
     * Return all of the Recipient Payments
     * @deprecated deprecated since version 3.x.x, will be removed in Q4 2023. Use Recipient.getAllPayments() instead.
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
            'amount',
            'currency',
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
            'coverFees',
            'taxReportable',
            'checkNumber',
            'tags',
            'estimatedDeliveryAt',
            'initiatedAt',
            'returnedAt',
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

    /**
     *  factory method: returns an array of Payment instances
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Array Payment
     */
    public static function factoryArray($arr)
    {   
        $instances = [];
        foreach ($arr as $key => $payment) {       
            $instance = new self();
            $instance->_initialize($payment);
            array_push($instances, $instance);
        }

        return $instances;
    }
}

class_alias('Trolley\Payment', 'Trolley_Payment');
