<?php
namespace Test\Integration;

require_once dirname(__DIR__) . '/Setup.php';

use Test;
use Test\Setup;
use Trolley;
use Ramsey\Uuid\Uuid;

//Class responsible for testing recipient payments.
class PaymentTest extends Setup
{
	//Function which will test to see if all recipient payments are returned.
    public function testAllPayments()
    {
        $recipientId = 'R-4QoXiSPjbnLuUmQR2bgb8C';

		$payments = Trolley\Payment::all($recipientId);
		foreach($payments as $pay)
		{
			$fee = $pay->fees;
			$sourceAmount = $pay->sourceAmount;
		}		
        $this->assertTrue($payments->maximumCount() > 0 && $sourceAmount > 0);
    }
	
	//Function which will test to see if they search works by only selecting the 
	//first 10 payments.
    public function testOnlyGet10Payments()
    {
        $recipientId = 'R-4QoXiSPjbnLuUmQR2bgb8C';

		$payments = Trolley\Payment::search($recipientId, ['page' => 1, 'pageSize' => 10]);
		$count = 0;
		foreach($payments as $pay)
		{
			$fee = $pay->fees;
			$sourceAmount = $pay->sourceAmount;
			$count++;
		}		
        $this->assertTrue($count == 10 && $sourceAmount > 0);
    }
}
