<?php
namespace Test\Integration;

require_once dirname(__DIR__) . '/Setup.php';

use Test;
use Test\Setup;
use Trolley;
use Ramsey\Uuid\Uuid;

//Class responsible for testing Invoice.
class InvoiceTest extends Setup
{	

	private function createRecipient() {
        $uuid = (string)Uuid::uuid4();

        $recipient = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones '. $uuid,
            'email' => 'test.batch+'.$uuid.'@example.com',
            'address' => [
                'street1' => "123 Wolfstrasse",
                'city' => "Berlin",
                'country' => "DE",
                'postalCode' => '123123',
            ],
        ]);

        return $recipient;
    }

    private function deleteRecipient($recipientId) {
        $response = Trolley\Recipient::delete($recipientId);
        $this->assertTrue($response);
    }

	public function testAllInvoices(){
		$allInvoices = Trolley\Invoice::listAll();
		$this->assertTrue($allInvoices->maximumCount() > 0);
	}

	public function testInvoiceActions()
	{	
		//Create a new recipient to create invoice against
		$recipient = $this->createRecipient();

		// Create Invoice
		$newInvoice = Trolley\Invoice::create([
			"recipientId" 	=> $recipient->id,
			"description" 	=> "PHP SDK Integration Test",
			"externalId"	=> "php-sdk-test-".(Uuid::uuid4())
		]);
		$this->assertTrue(str_contains($newInvoice->id,"I-"));

		// Update Invoice
		$updateInvoice = Trolley\Invoice::update([
			"invoiceId" 	=> $newInvoice->id,
			"description" 	=> "PHP SDK Integration Test - Update Invoice",
		]);
		$this->assertTrue(str_contains($updateInvoice->description," - Update Invoice"));

		// Fetch an Invoice
		$invoice = Trolley\Invoice::fetch($newInvoice->id);
		$this->assertTrue($invoice->id === $newInvoice->id);

		// Delete Invoice
		$deleteInvoice = Trolley\Invoice::delete($newInvoice->id);
		$this->assertTrue($deleteInvoice);

		// Delete test recipient
		$this->deleteRecipient($recipient->id);
	}

	public function testMultipleActions(){
		//Create a new recipient to create invoice against
		$recipient = $this->createRecipient();

		// Create First Invoice
		$firstInvoice = Trolley\Invoice::create([
			"recipientId" 	=> $recipient->id,
			"description" 	=> "PHP SDK Integration Test",
			"externalId"	=> "php-sdk-test-".(Uuid::uuid4())
		]);
		$this->assertTrue(str_contains($firstInvoice->id,"I-"));

		// Create Second Invoice
		$secondInvoice = Trolley\Invoice::create([
			"recipientId" 	=> $recipient->id,
			"description" 	=> "PHP SDK Integration Test Second Invoice",
			"externalId"	=> "php-sdk-test-".(Uuid::uuid4())
		]);
		$this->assertTrue(str_contains($secondInvoice->id,"I-"));

		// Search Invoices
		$searchResults = Trolley\Invoice::search([
			"recipientId" 	=> [$recipient->id],
			"page" => 1,
			"pageSize" => 5
		]);
		$this->assertTrue($searchResults->maximumCount() > 0);

		// Delete Multiple Invoice
		$deleteInvoices = Trolley\Invoice::deleteMultiple([
			$firstInvoice->id,
			$secondInvoice->id
		]);
		$this->assertTrue($deleteInvoices);

		// Delete test recipient
		$this->deleteRecipient($recipient->id);
	}
	
}
