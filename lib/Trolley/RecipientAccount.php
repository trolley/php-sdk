<?php
namespace Trolley;

/**
 * Trolley RecipientAccount module
 * PHP Version 5
 * Creates and manages Trolley RecipientsAccounts
 *
 * @package   Trolley
 *
 */
class RecipientAccount extends Base
{
    /**
     * @access protected
     * @var array registry of customer data
     */
    protected $_attributes = [
        "status" => "",
        "type" => "",
        "primary" => "",
        "currency" => "",
        "id" => "",
        "recipientId" => "",
        "recipientAccountId" => "",
        "disabledAt" => "",
        "deliveryBusinessDaysEstimate" => "",
        "country" => "",
        "iban" => "",
        "accountNum" => "",
        "bankAccountType" => "",
        "accountHolderName" => "",
        "swiftBic" => "",
        "branchId" => "",
        "bankId" => "",
        "bankName" => "",
        "bankAddress" => "",
        "bankCity" => "",
        "bankRegionCode" => "",
        "bankPostalCode" => "",
        "routeType" => "",
        "recipientFees" => ""
    ];

    /**
     * Get all accounts for a given recipient ID
     *
     * @param string $accountId
     * @throws Exception\NotFound
     * @return Iterator of RecipientAccount[]
     */
    public static function all($recipientId)
    {
        return Configuration::gateway()->recipientAccount()->all($recipientId);
    }

    /**
     * Get a single accountId
     *
     * @param string $recipientId
     * @param string $accountId
     * @throws Exception\NotFound
     * @return RecipientAccount
     */
    public static function find($recipientId, $accountId)
    {
        return Configuration::gateway()->recipientAccount()->find($recipientId, $accountId);
    }

    /**
     * Create a new recipient account
     * @param string $accountId
     * @param mixed $attrib
     * @return RecipientAccount
     */
    public static function create($recipientId, $attrib) {
        return Configuration::gateway()->recipientAccount()->create($recipientId, $attrib);
    }

    /**
     * Create a new recipient account for a given recipient
     *
     * @param string $recipientId
     * @param mixed $attrib
     */
    public static function update($recipientId, $accountId, $attrib) {
        return Configuration::gateway()->recipientAccount()->update($recipientId, $accountId, $attrib);
    }

    /**
     * Delete a new recipient account
     *
     * @param string $accountId
     * @throws Exception\NotFound
     */
    public static function delete($recipientId, $accountId) {
        return Configuration::gateway()->recipientAccount()->delete($recipientId, $accountId);
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
            "status",
            "type",
            "primary",
            "currency",
            "id",
            "recipientId",
            "recipientAccountId",
            "disabledAt",
            "deliveryBusinessDaysEstimate",
            "country",
            "iban",
            "accountNum",
            "bankAccountType",
            "accountHolderName",
            "swiftBic",
            "branchId",
            "bankId",
            "bankName",
            "bankAddress",
            "bankCity",
            "bankRegionCode",
            "bankPostalCode",
            "routeType",
            "recipientFees"
        ];

        foreach ($fields as $field) {
            if (isset($attributes[$field])) {
                $this->_set($field, $attributes[$field]);
            }
        }
    }


   /**
     *  factory method: returns an instance of RecipientAccount
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return RecipientAccount
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    /**
     *  factory method: returns an array of RecipientAccount instances
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Array RecipientAccount
     */
    public static function factoryArray($arr)
    {
        $instances = [];
        foreach ($arr as $key => $account) {
            $instance = new self();
            $instance->_initialize($account);
            array_push($instances, $instance);
        }

        return $instances;
    }
}

class_alias('Trolley\RecipientAccount', 'Trolley_RecipientAccount');
