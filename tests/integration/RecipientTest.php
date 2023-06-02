<?php
namespace Test\Integration;

require_once dirname(__DIR__) . '/Setup.php';

use Test;
use Test\Setup;
use Trolley;
use Ramsey\Uuid\Uuid;

class RecipientTest extends Setup
{
    public function testAll_smokeTest()
    {
        $all = Trolley\Recipient::all();
        $this->assertTrue($all->maximumCount() > 0);

        $all = Trolley\Recipient::getAllPayments("R-4QoXiSPjbnLuUmQR2bgb8C");
        $this->assertTrue($all->maximumCount() > 0);
    }

    public function testRouteMinimum()
    {
        $all = Trolley\Recipient::all();
        $this->assertTrue(isset($all->firstItem()->routeMinimum));
    }

    public function testSelectedRecipientAttributes()
    {
        $recipient = Trolley\Recipient::find("R-2PdMGp6oBqr7prs5z6G7xw");
        $this->assertTrue(isset($recipient->governmentIds));
        $this->assertEquals('NE', $recipient->governmentIds[0]['country']);
    }

    public function testCreate()
    {
        $uuid = (string)Uuid::uuid4();

        $recipient = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.create+'.$uuid.'@example.com',
            'address' => [
                'phone' => "+15142580232",
            ],
        ]);

        $this->assertNotNull($recipient);
        $this->assertEquals('Tom', $recipient->firstName);
        $this->assertEquals('Jones', $recipient->lastName);
        $this->assertEquals('+15142580232', $recipient->address->phone);

        $this->assertContains($uuid, $recipient->email);
        $this->assertNotNull($recipient->id);

        $deleteRecipient = Trolley\Recipient::delete($recipient->id);
        $this->assertTrue($deleteRecipient);
    }

    public function testLifecycle()
    {
        $uuid = (string)Uuid::uuid4();

        $createResult = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.lifecycle+'.$uuid.'@example.com',
        ]);
        $this->assertNotNull($createResult);
        $this->assertEquals('Tom', $createResult->firstName);
        $this->assertEquals('incomplete', $createResult->status);

        $updateResult = Trolley\Recipient::update($createResult->id, [
            "firstName" => "Bob",
        ]);
        $this->assertNotNull($updateResult);

        $fetchResult = Trolley\Recipient::find($createResult->id);
        $this->assertEquals('Bob', $fetchResult->firstName);

        $searchResult = Trolley\Recipient::search(
            [
                "name"      =>  $createResult->firstName,
                "page"      =>  1,
                "pageSize"  =>  2
            ]
        );
        $this->assertEquals($searchResult->firstItem()->firstName, $createResult->firstName);

        $deleteResult = Trolley\Recipient::delete($createResult->id);
        $this->assertTrue($deleteResult);

        $fetchDeletedResult = Trolley\Recipient::find($createResult->id);
        $this->assertEquals('archived', $fetchDeletedResult->status);
    }

    public function testMultipleDelete()
    {
        $uuid = (string)Uuid::uuid4();

        $recipientAlpha = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.lifecycle+'.$uuid.'@example.com',
        ]);

        $uuid = (string)Uuid::uuid4();
        $recipientBeta = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.lifecycle+'.$uuid.'@example.com',
        ]);

        $this->assertNotNull($recipientAlpha);
        $this->assertNotNull($recipientBeta);

        $deleteResult = Trolley\Recipient::deleteMultiple([$recipientAlpha->id, $recipientBeta->id]);
        $this->assertTrue($deleteResult);

        $fetchDeletedResult = Trolley\Recipient::find($recipientAlpha->id);
        $this->assertEquals('archived', $fetchDeletedResult->status);
    }

    //
    //  Recipient Account testing
    //
    public function testAccount()
    {
        $uuid = (string)Uuid::uuid4();

        $recipient = Trolley\Recipient::create([
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

        $account = Trolley\RecipientAccount::create($recipient->id, [
            "type" => "bank-transfer",
            "currency" => "EUR",
            "iban" => "DE89 3704 0044 0532 0130 00",
        ]);

        $this->assertNotNull($account);

        $account = Trolley\RecipientAccount::create($recipient->id, [
            "type" => "bank-transfer",
            "currency" => "EUR",
            "iban" => "FR14 2004 1010 0505 0001 3M02 606",
        ]);

        $this->assertNotNull($account);

        $findAccount = Trolley\RecipientAccount::find($recipient->id, $account->id);
        $this->assertEquals($account->iban, $findAccount->iban);

        $accountList = Trolley\RecipientAccount::all($recipient->id);

        $this->assertEquals(count($accountList), 2);
        $this->assertEquals($accountList[0]->currency, "EUR");

        $result = Trolley\RecipientAccount::delete($recipient->id, $account->id);
        $this->assertEquals(true, $result);

        $accountList = Trolley\RecipientAccount::all($recipient->id);
        $this->assertEquals(count($accountList), 1);

        $updatedRecipient = Trolley\Recipient::find($recipient->id);
        $this->assertEquals($updatedRecipient->accounts[0]->type, "bank-transfer");

        $deleteRecipient = Trolley\Recipient::delete($recipient->id);
        $this->assertTrue($deleteRecipient);
    }

    public function testAllLogs()
    {
        $uuid = (string)Uuid::uuid4();
        $recipient = Trolley\Recipient::create([
            'type' => "individual",
            'firstName' => 'Tom',
            'lastName' => 'Jones',
            'email' => 'test.create+'.$uuid.'@example.com',
            'address' => [
                'phone' => "+15142580232",
            ],
        ]);

        $this->assertNotNull($recipient);

        $allLogs = Trolley\Recipient::getAllLogs($recipient->id);
        $this->assertTrue($allLogs->maximumCount() > 0);

        $deleteRecipient = Trolley\Recipient::delete($recipient->id);
        $this->assertTrue($deleteRecipient);
    }

}
