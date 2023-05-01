<?php
namespace Trolley;
use Malformed;
/**
 * Trolley Invoice module
 * PHP Version 5
 * Creates and manages Trolley Invoices
 *
 * @package Trolley
 *
 */
class Invoice extends Base
{
    /**
     * @access protected
     * @var array registry of invoice data
     */
    protected $_attributes = [
        "id" => "",
        "invoiceNumber" => "",
        "description" => "",
        "status" => "",
        "externalId" => "",
        "invoiceDate" => "",
        "dueDate" => "",
        "createdAt" => "",
        "updatedAt" => "",
        "totalAmount" => "",
        "paidAmount" => "",
        "dueAmount" => "",
        "tags" => "",
        "lines" => "",
        "recipientId" => ""
    ];

    /**
     * Create a new Invoice
     */
    public static function create($attrib) {
        return Configuration::gateway()->invoice()->create($attrib);
    }

    /**
     * Fetch an invoice with id
     * @param int $id
     * @throws Exception\NotFound
     * @return Invoice
     */
    public static function fetch($id)
    {
        return Configuration::gateway()->invoice()->fetch($id);
    }

    /**
     * Fetch all invoices.
     * @throws Exception\NotFound
     * @return Iterator of Invoice[]
     */
    public static function listAll()
    {
        return Configuration::gateway()->invoice()->search([]);
    }

    /**
     * Search for invoices
     * @param mixed $params search keywords and parameters
     * @throws Exception\NotFound
     * @return Iterator of Invoice[]
     */
    public static function search($params)
    {
        return Configuration::gateway()->invoice()->search($params);
    }

    /**
     * Update an Invoice. `invoiceId` should be included in $attrib array
     */
    public static function update($attrib) {
        return Configuration::gateway()->invoice()->update($attrib);
    }

    /**
     * Delete an Invoice
     * @param string $id ID of the invoice you want to delete
     */
    public static function delete($id) {
        return Configuration::gateway()->invoice()->delete([
            "invoiceIds" => [
                $id
                ]
            ]);
    }

    /**
     * Delete multiple Invoices.
     * @param array $invoiceIds array of invoice IDs that you want to delete.
     */
    public static function deleteMultiple($invoiceIds = []) {
        return Configuration::gateway()->invoice()->delete([
            "invoiceIds" => $invoiceIds
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
            "id",
            "invoiceNumber",
            "description",
            "status",
            "externalId",
            "invoiceDate",
            "dueDate",
            "createdAt",
            "updatedAt",
            "totalAmount",
            "paidAmount",
            "dueAmount",
            "tags",
            "lines" => "Trolley\InvoiceLine::factoryArray",
            "recipientId"
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
     *  factory method: returns an instance of Invoice
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Invoice
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }
}

class_alias('Trolley\Invoice', 'Trolley_Invoice');
