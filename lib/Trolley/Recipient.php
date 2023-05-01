<?php
namespace Trolley;
use Malformed;
/**
 * Trolley Recipient module
 * PHP Version 5
 * Creates and manages Trolley Recipients
 *
 * @package   Trolley
 *
 */
class Recipient extends Base
{
    /**
     * @access protected
     * @var array registry of recipient data
     */
    protected $_attributes = [
        "id" => "",
        "referenceId" => "",
        "email" => "",
        "name" => "",
        "lastName" => "",
        "firstName" => "",
        "status" => "",
        "complianceStatus" => "",
        "gravatarUrl" => "",
        "language" => "",
        "dob" => "",
        "passport" => "",
        "ssn" => "",
        "governmentId" => "",       //deprecated
        "governmentIds" => "",
        "routeType" => "",
        "routeMinimum" => "",
        
        "estimatedFees" => "",
        "type" => "",
        "updatedAt" => "",
        "createdAt" => "",
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
     * Create a new recipient
     */
    public static function create($attrib) {
        return Configuration::gateway()->recipient()->create($attrib);
    }

    /**
     * Update a recipient
     */
    public static function update($id, $attrib) {
        return Configuration::gateway()->recipient()->update($id, $attrib);
    }

    /**
     * Delete a recipient
     */
    public static function delete($id) {
        return Configuration::gateway()->recipient()->delete($id);
    }

    /**
     * Delete multiple recipients
     */
    public static function deleteMultiple($ids) {
        if(!is_array($ids)){
            throw new Exception\Malformed("Recipient::deleteMultiple() expects array parameters.");
        }

        if(count($ids)==0){
            throw new Exception\Malformed("array parameters is empty.");
        }
        return Configuration::gateway()->recipient()->deleteMultiple(["ids" => $ids]);
    }
    
    /**
     * Get all logs of a recipient
     */
    public static function getAllLogs($id) {
        return Configuration::gateway()->recipient()->getAllLogs([$id]);
    }

    /**
     * Return all of the Recipient Payments
     *
     * @param string $recipientId of the recipient whose payments need to be fetched
     * @throws Exception\NotFound
     * @return Iterator of Payment[]
     */
    public static function getAllPayments($recipientId)
    {
        return Configuration::gateway()->recipient()->getAllPayments($recipientId);
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
        "referenceId",
        "email",
        "name",
        "lastName",
        "firstName",
        "status",
        "complianceStatus",
        "gravatarUrl",
        "language",
        "dob",
        "passport",
        "ssn",
        "governmentId",       //deprecated
        "governmentIds",
        "routeType",
        "routeMinimum",
        
        "estimatedFees",
        "type",
        "updatedAt",
        "createdAt",
        "primaryCurrency",
        "merchantId",
        "payoutMethod",
        "compliance",
        "accounts" => 'Trolley\RecipientAccount::factoryArray',         // Specifies factory method
        "address" => 'Trolley\RecipientAddress::factory',
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
     *  factory method: returns an instance of Recipient
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Recipient
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }
}

class_alias('Trolley\Recipient', 'Trolley_Recipient');
