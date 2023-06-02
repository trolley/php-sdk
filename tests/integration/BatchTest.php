<?php
namespace Test\Integration;

require_once dirname(__DIR__) . '/Setup.php';

use Test;
use Test\Setup;
use Trolley;
use Trolley\Exception\Standard;
use Ramsey\Uuid\Uuid;

class BatchTest extends Setup {

    private function createRecipient() {
        $uuid = (string)Uuid::uuid4();

        $recipient = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones '. $uuid,
            'email' => 'test.batch.php+'.$uuid.'@example.com',
            'address' => [
                'street1' => "123 Wolfstrasse",
                'city' => "Berlin",
                'country' => "DE",
                'postalCode' => '123123',
            ],
        ]);

        return $recipient;
    }

    private function createRecipientAccount($recipientId){
        $account = Trolley\RecipientAccount::create($recipientId, [
            "type" => "bank-transfer",
            "currency" => "EUR",
            "iban" => "DE89 3704 0044 0532 0130 00",
        ]);
    }

    private function deleteRecipient($recipientId) {
        $response = Trolley\Recipient::delete($recipientId);
        $this->assertTrue($response);
    }

    public function testErrors(){

        //create inactive Recipient to send payment to
        $recipient = $this->createRecipient();

        // create batch with errors (non-equal currencies)
        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Create"
        ],
        [
            [
                "targetAmount" => "10.00",
                "targetCurrency" => "EUR",
                "recipient" => [ "id" => $recipient->id ]
            ]
        ]);

        try{
            //process the batch to encounter errors
            $batchProcessing = Trolley\Batch::startProcessing($batch->id);
        }catch(Trolley\Exception\Standard $e){
            // Assert we got an Error array
            $this->assertInternalType('array', $e->getAllErrorsAsArray());
        }

        // cleanup: Delete Batch & Recipient
        Trolley\Batch::delete($batch->id);
        $this->deleteRecipient($recipient->id);
    }

    public function testAll_smokeTest()
    {
        $all = Trolley\Batch::all();
        $this->assertTrue($all->maximumCount() > 0);

        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description"    => "Integration Test Create : PHP SDK",
            "tags"           => ["PHPSDK"]
        ]);

        $searchResult = Trolley\Batch::search([
            "search"    => "PHPSDK",
            "page"      => 1,
            "pageSize"  => 5
        ]);

        $this->assertEquals($searchResult->firstItem()->id, $batch->id);
        
        $response = Trolley\Batch::delete($batch->id);
        $this->assertTrue($response);
    }

    public function testBalances(){
        $allBalances = Trolley\Balance::all();
        $this->assertTrue($allBalances->maximumCount() > 0);

        $trolleyBalances = Trolley\Balance::getTrolleyAccountBalance();
        $this->assertTrue($trolleyBalances->maximumCount() > 0);
        
        $paypalBalances = Trolley\Balance::getPaypalAccountBalance();
        $this->assertTrue($paypalBalances->maximumCount() > 0);

    }

    public function testMultipleDelete()
    {
        $batchAlpha = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Create : Delete Multiple Batch 1"
        ]);
        $batchBeta = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Create : Delete Multiple Batch 1"
        ]);

        $this->assertNotNull($batchAlpha);
        $this->assertNotNull($batchBeta->id);

        $response = Trolley\Batch::deleteMultiple([$batchAlpha->id, $batchBeta->id]);
        $this->assertTrue($response);
    }

    public function testCreate()
    {
        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Create"
        ]);
        $this->assertNotNull($batch);
        $this->assertNotNull($batch->id);

        $all = Trolley\Batch::all();
        $this->assertTrue($all->maximumCount() > 0);

        $response = Trolley\Batch::delete($batch->id);
        $this->assertTrue($response);
    }

    public function testUpdate() {
        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Create"
        ]);
        $this->assertNotNull($batch);
        $this->assertNotNull($batch->id);

        $all = Trolley\Batch::all();
        $this->assertTrue($all->maximumCount() > 0);

        $response = Trolley\Batch::update($batch->id, [
            "description" => "Integration Update",
        ]);

        $this->assertTrue($response);

        $findBatch = Trolley\Batch::find($batch->id);

        $this->assertEquals("Integration Update", $findBatch->description);
        $this->assertEquals("open", $findBatch->status);

        $response = Trolley\Batch::delete($batch->id);

        $this->assertTrue($response);
    } 

    public function testCreateWithPayments()
    {
        $recipientAlpha = $this->createRecipient();
            $this->createRecipientAccount($recipientAlpha->id);
        $recipientBeta = $this->createRecipient();
            $this->createRecipientAccount($recipientBeta->id);

        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Payments"
        ], [
            [
                "targetAmount" => "10.00",
                "targetCurrency" => "EUR",
                "recipient" => [ "id" => $recipientAlpha->id ]
            ],
            [
                "sourceAmount" => "10.00",
                "recipient" => [ "id" => $recipientBeta->id ]
            ],
        ]);
        $this->assertNotNull($batch);
        $this->assertNotNull($batch->id);

        $findBatch = Trolley\Batch::find($batch->id);
        $this->assertNotNull($findBatch);
        $this->assertEquals(2, $findBatch->totalPayments);
        $this->assertEquals($findBatch->payments[0]->recipient["id"], $recipientAlpha->id);

        $payments = Trolley\Batch::payments($batch->id);
        foreach ($payments as $item) {
            $this->assertEquals("pending", $item->status);
        }

        $response = Trolley\Batch::delete($batch->id);
        $this->assertTrue($response);

        $this->deleteRecipient($recipientAlpha->id);
        $this->deleteRecipient($recipientBeta->id);
    }

    public function testPayments()
    {
        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "Integration Test Payments"
        ]);
        $this->assertNotNull($batch);
        $this->assertNotNull($batch->id);

        $recipient = $this->createRecipient();
            $this->createRecipientAccount($recipient->id);

        $payment = Trolley\Batch::createPayment($batch->id, [
            "sourceAmount" => "10.00",
            "recipient" => [ "id" => $recipient->id ]
        ]);

        $this->assertNotNull($payment);
        $this->assertNotNull($payment->id);

        $response = Trolley\Batch::updatePayment($batch->id, $payment->id, [
            "sourceAmount" => "20.00",
        ]);

        $this->assertTrue($response);

        $response = Trolley\Batch::findPayment($batch->id, $payment->id);
        $this->assertEquals($response->id, $payment->id);

        $response = Trolley\Batch::deletePayment($batch->id, $payment->id);

        $this->assertTrue($response);

        $response = Trolley\Batch::delete($batch->id);
        $this->assertTrue($response);

        $this->deleteRecipient($recipient->id);
    }

    public function testProcessing()
    {
        $recipientAlpha = $this->createRecipient();
            $this->createRecipientAccount($recipientAlpha->id);
        $recipientBeta = $this->createRecipient();
            $this->createRecipientAccount($recipientBeta->id);

        $batch = Trolley\Batch::create([
            "sourceCurrency" => "USD",
            "description" => "PHP Integration Test Payments"
        ], [
            [
                "targetAmount" => "10.00",
                "targetCurrency" => "EUR",
                "recipient" => [ "id" => $recipientAlpha->id ]
            ],
            [
                "sourceAmount" => "10.00",
                "recipient" => [ "id" => $recipientBeta->id ]
            ],
        ]);

        $this->assertNotNull($batch);
        $this->assertNotNull($batch->id);

        $summary = Trolley\Batch::summary($batch->id);
        $this->assertEquals(2, $summary->detail['bank-transfer']['count']);
        try{
            $quote = Trolley\Batch::generateQuote($batch->id);

            $this->assertNotNull($quote);
        
            $start = Trolley\Batch::startProcessing($batch->id);
            $this->assertNotNull($start);

            Trolley\Batch::delete($batch->id);
        }catch(Standard $e){
            echo $e;
            Trolley\Batch::delete($batch->id);
        }

        $this->deleteRecipient($recipientAlpha->id);
        $this->deleteRecipient($recipientBeta->id);
    }
}