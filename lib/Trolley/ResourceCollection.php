<?php
namespace Trolley;

use Iterator;

/**
 * Trolley ResourceCollection
 * ResourceCollection is a container object for result data
 *
 * stores and retrieves search results and aggregate data
 *
 * example:
 * <code>
 * $result = Trolley_Recipient::all();
 *
 * foreach($result as $recipient) {
 *   print_r($recipient['id']);
 * }
 * </code>
 *
 * @package    Trolley
 * @subpackage Utility
 */
class ResourceCollection implements Iterator
{
    private $_index;
    private $_items;
    private $_page;
    private $_records;
    private $_pager;
    private $_maxPages;

    /**
     * set up the resource collection
     *
     * expects an array of attributes with literal keys
     *
     * @param array $response
     * @param array $pager
     */
    public function  __construct($response, $items, $pager)
    {
        // Add "meta" fields only when they exist in JSON response
        $this->_page = isset($response["meta"]) ? $response["meta"]["page"] : 1;
        $this->_items = $items;
        $this->_records = isset($response["meta"]) ? $response["meta"]["records"] : count($items);
        $this->_pager = $pager;
        $this->_index = 0;
        if (isset($response["meta"]["pages"])) {
            $this->_maxPages = $response["meta"]["pages"];
        } else {
            $this->_maxPages = count($this->_items) === 0 ? 1 : $this->_records / count($this->_items);
        }
    }

    /**
     * returns the current item when iterating with foreach
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->_items[$this->_index];
    }

    /**
     * returns the first item in the collection
     *
     * @return mixed
     */
    public function firstItem()
    {
        return $this->_items[0];
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return null;
    }

    /**
     * advances to the next item in the collection when iterating with foreach
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        ++$this->_index;
    }

    /**
     * rewinds the testIterateOverResults collection to the first item when iterating with foreach
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->_index = 0;
    }

    /**
     * returns whether the current item is valid when iterating with foreach
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        if ($this->_index >= count($this->_items)) {
            if ($this->_page + 1 >= $this->_maxPages) {
                return false;
            }
            $this->_getNextPage();
        }
        return $this->_index < $this->_records;
    }

    public function maximumCount()
    {
        return $this->_records;
    }

    private function _getNextPage()
    {
        $result = $this->_getPage($this->_page + 1);
        $this->_items = $result->_items;
        $this->_index = 0;
        ++$this->_page;
    }

    /**
     * requests the next page of results for the collection
     *
     * @return void
     */
    private function _getPage($page)
    {
        $object = $this->_pager['object'];
        $method = $this->_pager['method'];
        $args = [ "page" => $page ];

        foreach ($this->_pager["methodArgs"] as $arg => $value) {
            if ($arg !== "page") {
                $args[$arg] = $value;
            }
        }

        return call_user_func_array(
            [$object, $method],
            [$args]
        );
    }
}

class_alias('Trolley\ResourceCollection', 'Trolley_ResourceCollection');
