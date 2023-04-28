<?php
namespace Trolley;

/**
 * Trolley Balance module
 * PHP Version 5
 * Gets merchant balances
 *
 * @package   Trolley
 *
 */
class Balance extends Base
{
    /**
     * @access protected
     * @var array registry of customer data
     */
    protected $_attributes = [
        "accountNumber",
        "amount",
        "amountCleared",
        "amountPending",
        "currency",
        "display",
        "pendingCredit",
        "pendingDebit",
        "primary",
        "provider",
        "providerAcct",
        "providerId",
        "type"
    ];

    /**
     * Show all balances
     *
     * @return Balance
     */
    public static function all()
    {
        return Configuration::gateway()->balance()->search("",[]);
    }

    /**
     * Show Trolley account balances
     *
     * @return Balance
     */
    public static function getTrolleyAccountBalance()
    {
        return Configuration::gateway()->balance()->search("paymentrails", []);
    }

    /**
     * Show Paypal account balances
     *
     * @return Balance
     */
    public static function getPaypalAccountBalance()
    {
        return Configuration::gateway()->balance()->search("paypal", []);
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
          "accountNumber",
          "amount",
          "amountCleared",
          "amountPending",
          "currency",
          "display",
          "pendingCredit",
          "pendingDebit",
          "primary",
          "provider",
          "providerAcct",
          "providerId",
          "type"
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

class_alias('Trolley\Balance', 'Trolley_Balance');
