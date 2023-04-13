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

	public function testInvoiceLineActions()
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

		// Create two Invoice Lines
		$invoiceWithLines = Trolley\InvoiceLine::create($newInvoice->id, [
			[
				"unitAmount" =>[
					"value" => "50.00",
				 	"currency" => "EUR"
				],
				"description" 	=> "first line",
				"category"		=> Trolley\InvoiceLine::$categories["services"]
			],
			[
				"unitAmount" =>[
					"value" => "50.00",
				 	"currency" => "EUR"
				],
				"description" => "second line"
			]
		]);
		$this->assertTrue(count($invoiceWithLines->lines) == 2);
		$this->assertTrue($invoiceWithLines->lines[0]->category == Trolley\InvoiceLine::$categories["services"]);
		$this->assertTrue($invoiceWithLines->lines[0]->description == "first line");
		$this->assertTrue($invoiceWithLines->lines[1]->description == "second line");

		// Update both Invoice Lines
		$updatedInvoice = Trolley\InvoiceLine::update($newInvoice->id, [
			[
				"invoiceLineId" => $invoiceWithLines->lines[0]->id,
				"description"	=> "updated first line"
			],
			[
				"invoiceLineId" => $invoiceWithLines->lines[1]->id,
				"unitAmount" =>[
					"value" => "150.00",
				 	"currency" => "EUR"
				]
			]
		]);
		$this->assertTrue($updatedInvoice->lines[0]->description == "updated first line");
		$this->assertTrue($updatedInvoice->lines[1]->unitAmount["value"] == "150.00");

		// Delete both Invoice Lines
		$invoiceWithNoLines = Trolley\InvoiceLine::delete($newInvoice->id,[
			$invoiceWithLines->lines[0]->id,
			$invoiceWithLines->lines[1]->id
		]);
		$this->assertTrue(empty($invoiceWithNoLines->lines));

		// Delete the Invoice
		$deleteInvoice = Trolley\Invoice::delete($newInvoice->id);
		$this->assertTrue($deleteInvoice);

		// Delete test recipient
		$this->deleteRecipient($recipient->id);
	}
}
