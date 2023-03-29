<?php

use PHPUnit\Framework\TestCase;
use Trolley\Exception\Standard;

class StandardTest extends TestCase
{
    public function testExceptionWithString()
    {
    	$this->expectException(Standard::class);
    	$this->expectExceptionMessage('unknown');
    	throw new Standard('unknown');
    }

    public function testExceptionWithArray()
    {
    	$errorBody = array(
    		array(
    			'code' => 404,
    			'message' => 'not found',
    			'field' => 'text'
    		),
    		array(
    			'code' => 202,
    			'message' => 'success'
    		)
    	);
    	$this->expectException(Standard::class);
    	$this->expectExceptionMessage(
    		"404: not found (field: text)\n202: success\n"
    	);
    	throw new Standard($errorBody);
    }
}
