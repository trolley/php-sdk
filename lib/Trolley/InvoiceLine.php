<?php
namespace Trolley;
use Malformed;
/**
 * Trolley InvoiceLine module
 * PHP Version 5
 * Creates and manages Trolley InvoicesLines
 *
 * @package Trolley
 *
 */
class InvoiceLine extends Base
{
    public static $categories = [
        "services"      =>  "services", 	    // Services
        "rent"          =>  "rent",  	        // Rent
        "royalties"     =>  "royalties", 	    // Royalties
        "royalties_film"=>  "royalties_film", 	// Royalties Film & TV
        "prizes"        =>  "prizes", 	        // Prize payment
        "education"     =>  "education", 	    // Education
        "refunds"       =>  "refunds" 	        // Refunds
    ];

    /**
     * @access protected
     * @var array registry of invoice data
     */
    protected $_attributes = [
        "id" => "",
        "status" => "",
        "unitAmount" => "",
        "taxAmount" => "",
        "totalAmount" => "",
        "dueAmount" => "",
        "paidAmount" => "",
        "category" => "",
        "royalties" => "",
        "description" => "",
        "externalId" => "",
        "taxReportable" => "",
        "forceUsTaxActivity" => "",
        "tags" => ""
    ];

    /**
     * Create a new Invoice Line in the invoice whose ID is provided.
     * @param string $invoiceId ID of the invoice where this line item needs to be created.
     * @param array $lineItems Array of line items.
     */
    public static function create($invoiceId, $lineItems) {
        return Configuration::gateway()->invoiceLine()->create([
            "invoiceId" => $invoiceId,
            "lines"     => $lineItems
        ]);
    }

    /**
     * Update one or multiple Invoice line items, in the invoice whose ID is provided.
     * @param string $invoiceId ID of the invoice whose line item need to be updated.
     * @param array $lineItems Array of line items with $invoiceLineIds and fields to update.
     */
    public static function update($invoiceId, $lineItems) {
        return Configuration::gateway()->invoiceLine()->update([
            "invoiceId" => $invoiceId,
            "lines"     => $lineItems
        ]);
    }

    /**
     * Delete an Invoice
     * @param string $invoiceId ID of the invoice whose line item need to be deleted.
     * @param array $lineItems Array of invoiceLineIds that need to be deleted.
     */
    public static function delete($invoiceId, $lineItems) {
        return Configuration::gateway()->invoiceLine()->delete([
            "invoiceId"         => $invoiceId,
            "invoiceLineIds"    => $lineItems
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
            "status",
            "unitAmount",
            "taxAmount",
            "totalAmount",
            "dueAmount",
            "paidAmount",
            "category",
            "royalties",
            "description",
            "externalId",
            "taxReportable",
            "forceUsTaxActivity",
            "tags"
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
     *  factory method: returns an instance of InvoiceLine
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

    /**
     *  factory method: returns an array of InvoiceLine instances
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return Array InvoiceLine
     */
    public static function factoryArray($arr)
    {
        $instances = [];
        foreach ($arr as $key => $invoiceLine) {
            $instance = new self();
            $instance->_initialize($invoiceLine);
            array_push($instances, $instance);
        }

        return $instances;
    }
}

class_alias('Trolley\InvoiceLine', 'Trolley_InvoiceLine');
