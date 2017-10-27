<?php
namespace Test\Integration;

require_once dirname(__DIR__) . '/Setup.php';

use Test;
use Test\Setup;
use PaymentRails;
use Ramsey\Uuid\Uuid;

class RecipientTest extends Setup
{
    public function testAll_smokeTest()
    {
        $all = PaymentRails\Recipient::all();
        $this->assertTrue($all->maximumCount() > 0);
    }

    public function testCreate()
    {
        $uuid = (string)Uuid::uuid4();

        $recipient = PaymentRails\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.create+'.$uuid.'@example.com',
        ]);

        $this->assertNotNull($recipient);
        $this->assertEquals('Tom', $recipient->firstName);
        $this->assertEquals('Jones', $recipient->lastName);
        $this->assertContains($uuid, $recipient->email);
        $this->assertNotNull($recipient->id);
    }

    public function testLifecycle()
    {
        $uuid = (string)Uuid::uuid4();

        $createResult = PaymentRails\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.lifecycle+'.$uuid.'@example.com',
        ]);
        $this->assertNotNull($createResult);
        $this->assertEquals('Tom', $createResult->firstName);
        $this->assertEquals('incomplete', $createResult->status);

        $updateResult = PaymentRails\Recipient::update($createResult->id, [
            "firstName" => "Bob",
        ]);
        $this->assertNotNull($updateResult);

        $fetchResult = PaymentRails\Recipient::find($createResult->id);
        $this->assertEquals('Bob', $fetchResult->firstName);

        $deleteResult = PaymentRails\Recipient::delete($createResult->id);
        $this->assertTrue($deleteResult);

        $fetchDeletedResult = PaymentRails\Recipient::find($createResult->id);
        $this->assertEquals('archived', $fetchDeletedResult->status);
    }

    //
    //  Recipient Account testing
    //
    public function testAccount()
    {
        $uuid = (string)Uuid::uuid4();

        $recipient = PaymentRails\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.create+'.$uuid.'@example.com',
            'address' => [
                'street1' => "123 Wolfstrasse",
                'city' => "Berlin",
                'country' => "DE",
                'postalCode' => '123123',
            ],
        ]);

        $this->assertNotNull($recipient);
        $this->assertEquals('Tom', $recipient->firstName);
        $this->assertEquals('Jones', $recipient->lastName);
        $this->assertContains($uuid, $recipient->email);
        $this->assertNotNull($recipient->id);

        $account = PaymentRails\RecipientAccount::create($recipient->id, [
            "type" => "bank-transfer",
            "currency" => "EUR",
            "iban" => "DE89 3704 0044 0532 0130 00",
        ]);

        $this->assertNotNull($account);

        $account = PaymentRails\RecipientAccount::create($recipient->id, [
            "type" => "bank-transfer",
            "currency" => "EUR",
            "iban" => "FR14 2004 1010 0505 0001 3M02 606",
        ]);

        $this->assertNotNull($account);

        $findAccount = PaymentRails\RecipientAccount::find($recipient->id, $account->id);
        $this->assertEquals($account->iban, $findAccount->iban);

        $accountList = PaymentRails\RecipientAccount::all($recipient->id);

        $this->assertEquals(count($accountList), 2);
        $this->assertEquals($accountList[0]->currency, "EUR");

        $result = PaymentRails\RecipientAccount::delete($recipient->id, $account->id);
        $this->assertEquals(true, $result);

        $accountList = PaymentRails\RecipientAccount::all($recipient->id);
        $this->assertEquals(count($accountList), 1);
    }
}
