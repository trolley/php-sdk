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
            'email' => 'test.invoice.payments+'.$uuid.'@example.com',
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
		// Setup - Create a new recipient to create invoice against
		$recipient = $this->createRecipient();

		// Setup - Create Invoice
		$newInvoice = Trolley\Invoice::create([
			"recipientId" 	=> $recipient->id,
			"description" 	=> "PHP SDK Integration Test",
			"externalId"	=> "php-sdk-test-".(Uuid::uuid4())
		]);
		$this->assertTrue(str_contains($newInvoice->id,"I-"));

		// Setup - Add two lines to the created invoice
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
		

		// Create InvoicePayment
		$invoicePayment = Trolley\InvoicePayment::create([
			[
				"invoiceId" => $invoiceWithLines->id,
				"invoiceLineId" => $invoiceWithLines->lines[0]->id,
				"amount" => [
					"value" => $invoiceWithLines->lines[0]->unitAmount["value"],
					"currency" => $invoiceWithLines->lines[0]->unitAmount["currency"]
				]
			],
			[
				"invoiceId" => $invoiceWithLines->id,
				"invoiceLineId" => $invoiceWithLines->lines[1]->id,
				"amount" => [
					"value" => $invoiceWithLines->lines[1]->unitAmount["value"],
					"currency" => $invoiceWithLines->lines[0]->unitAmount["currency"]
				]
			]
		]);
		$this->assertTrue($invoicePayment[0]->amount['value'] == "50.00");

		// Update InvoicePayment
		$updatedInvoicePayment = Trolley\InvoicePayment::update([
			"invoiceLineId" => $invoiceWithLines->lines[0]->id,
			"paymentId" => $invoicePayment[0]->paymentId,
			"amount" => [
				"value" => "102.10",
				"currency" => $invoiceWithLines->lines[0]->unitAmount["currency"]
			]
		]);
		$this->assertTrue($updatedInvoicePayment);

		// Search InvoicePayment
		$searchedInvoicePayment = Trolley\InvoicePayment::search([$invoicePayment[0]->paymentId], [$invoiceWithLines->id]);
		$this->assertTrue($searchedInvoicePayment->current()->amount["value"] == "50.00");

		// Delete an InvoicePayment
		$deletedInvoicePayments = Trolley\InvoicePayment::delete($invoicePayment[0]->paymentId, [
			$invoiceWithLines->lines[0]->id,
			$invoiceWithLines->lines[1]->id
		]);
		$this->assertTrue($deletedInvoicePayments);

		// Cleanup - Delete Invoice
		$deleteInvoice = Trolley\Invoice::delete($newInvoice->id);
		$this->assertTrue($deleteInvoice);

		// Cleanup - Delete test recipient
		$this->deleteRecipient($recipient->id);
	}
}
