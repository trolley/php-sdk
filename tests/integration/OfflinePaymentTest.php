<?php
namespace Test\Integration;

require_once dirname(__DIR__) . '/Setup.php';

use Test;
use Test\Setup;
use Trolley;
use Ramsey\Uuid\Uuid;

//Class responsible for testing offline payments.
class OfflinePaymentTest extends Setup
{
	public function testOfflinePayments()
	{
		$uuid = (string)Uuid::uuid4();
		$recipient = Trolley\Recipient::create([
			'type' => "individual",
			'firstName' => 'Tom',
			'lastName' => 'Jones',
			'email' => 'test.offlinepayments.phpsdk+'.$uuid.'@example.com',
			'address' => [
				'phone' => "+15142580232",
			],
		]);

		//Create an offline payment
		$offlinePayment = Trolley\OfflinePayment::create($recipient->id,[
			"currency" => "CAD",
			"amount" => "10.00",
			"payoutMethod" => "paypal",
			"category" => "services",
			"memo" => "PHP SDK Integration Test Payment",
			"processedAt" => "2022-06-22T01:10:17.571Z"
		]);
		$this->assertTrue(str_contains($offlinePayment->id,"OP-"));

		//Update an offline payment
		$updatedOfflinePayments = Trolley\OfflinePayment::update($recipient->id, $offlinePayment->id, [
			"memo" => "PHP SDK Integration Test Offline Payment Update",
		]);
		$this->assertTrue($updatedOfflinePayments);

		//List all offline payments
		$allOfflinePayments = Trolley\OfflinePayment::all(1,3);
		$this->assertTrue($allOfflinePayments->maximumCount()>0);
		$this->assertTrue(str_contains($allOfflinePayments->current()->id,"OP-"));

		//Search for offline payments
		$searchOfflinePayments = Trolley\OfflinePayment::search([
			"search" => "PHP"
		]);
		$this->assertTrue($searchOfflinePayments->maximumCount()>0);
		$this->assertTrue(str_contains($searchOfflinePayments->current()->memo,"PHP"));

		//Delete offline payment
		$offlinePayment = Trolley\OfflinePayment::delete($recipient->id, $offlinePayment->id);
		$this->assertTrue($offlinePayment);

		//Recipient cleanup
		$recipient = Trolley\Recipient::delete($recipient->id);
		$this->assertTrue($recipient);
	}
	
}
