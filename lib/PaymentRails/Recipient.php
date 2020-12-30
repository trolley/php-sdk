<?php
namespace PaymentRails;

/**
 * PaymentRails Recipient module
 * PHP Version 5
 * Creates and manages PaymentRails Recipients
 *
 * @package   PaymentRails
 *
 */
class Recipient extends Base
{
    /**
     * @access protected
     * @var array registry of customer data
     */
    protected $_attributes = [
        "id" => "",
        "routeType" => "",
        "estimatedFees" => "",
        "referenceId" => "",
        "email" => "",
        "name" => "",
        "lastName" => "",
        "firstName" => "",
        "type" => "",
        "taxType" => "",
        "status" => "",
        "language" => "",
        "complianceStatus" => "",
        "dob" => "",
        "passport" => "",
        "updatedAt" => "",
        "createdAt" => "",
        "gravatarUrl" => "",
        "governmentId" => "",
        "ssn" => "",
        "primaryCurrency" => "",
        "merchantId" => "",
        "payoutMethod" => "",

        "compliance" => "",
        "accounts" => "",
        "address" => "",
    ];

    /**
     * Return all of the recipients
     *
     * @throws Exception\NotFound
     * @return Iterator of Recipient[]
     */
    public static function all()
    {
        return Configuration::gateway()->recipient()->search([]);
    }

    /**
     *
     * @param mixed $params
     * @throws Exception\NotFound
     * @return Iterator of Recipient[]
     */
    public static function search($params)
    {
        return Configuration::gateway()->recipient()->search($params);
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
     *
     * @param int $id
     * @throws Exception\NotFound
     * @return Recipient
     */
    public static function tax($id)
    {
        return Configuration::gateway()->recipient()->tax($id);
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
            "id",
            "routeType",
            "estimatedFees",
            "id",
            "referenceId",
            "email",
            "name",
            "lastName",
            "firstName",
            "type",
            "taxType",
            "status",
            "language",
            "complianceStatus",
            "dob",
            "passport",
            "updatedAt",
            "createdAt",
            "gravatarUrl",
            "governmentId",
            "ssn",
            "primaryCurrency",
            "merchantId",
            "payoutMethod",

            "compliance",       // TODO: Factory
            "accounts",         // TODO: Factory
            "address",          // TODO: Factory
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

class_alias('PaymentRails\Recipient', 'PaymentRails_Recipient');
