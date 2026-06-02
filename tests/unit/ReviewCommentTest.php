<?php

use PHPUnit\Framework\TestCase;
use Trolley\InvoicePayment;
use Trolley\OfflinePayment;
use Trolley\Payment;
use Trolley\RecipientAccount;

class ReviewCommentTest extends TestCase
{
    public function testNewModelAttributesKeepDefaultValues()
    {
        $this->assertSame('', InvoicePayment::factory([])->amount);
        $this->assertSame('', OfflinePayment::factory([])->deletedAt);
        $this->assertSame('', RecipientAccount::factory([])->recipientFees);
    }

    public function testPaymentAttributesAreUnique()
    {
        $attributes = $this->attributesFor(Payment::factory([]));

        $this->assertSame(count($attributes), count(array_unique($attributes)));
    }

    public function testRecipientOfflinePaymentsPaginationKeepsRecipientId()
    {
        $http = new FakeHttp([
            [
                'ok' => true,
                'offlinePayments' => [['id' => 'OP-1']],
                'meta' => ['page' => 1, 'pages' => 2, 'records' => 2],
            ],
            [
                'ok' => true,
                'offlinePayments' => [['id' => 'OP-2']],
                'meta' => ['page' => 2, 'pages' => 2, 'records' => 2],
            ],
        ]);
        $gateway = $this->gatewayWithHttp('Trolley\RecipientGateway', $http);

        $ids = [];
        foreach ($gateway->getAllOfflinePayments('R-1', ['recipientId' => 'R-wrong', 'pageSize' => 1]) as $payment) {
            $ids[] = $payment->id;
        }

        $this->assertSame(['OP-1', 'OP-2'], $ids);
        $this->assertSame('/v1/recipients/R-1/offlinePayments', $http->requests[1][0]);
        $this->assertSame(['page' => 2, 'pageSize' => 1], $http->requests[1][1]);
    }

    public function testBalancePaginationHasPager()
    {
        $http = new FakeHttp([
            [
                'ok' => true,
                'balances' => [['accountNumber' => 'A-1']],
                'meta' => ['page' => 1, 'pages' => 2, 'records' => 2],
            ],
            [
                'ok' => true,
                'balances' => [['accountNumber' => 'A-2']],
                'meta' => ['page' => 2, 'pages' => 2, 'records' => 2],
            ],
        ]);
        $gateway = $this->gatewayWithHttp('Trolley\BalanceGateway', $http);

        $accountNumbers = [];
        foreach ($gateway->all(['pageSize' => 1]) as $balance) {
            $accountNumbers[] = $balance->accountNumber;
        }

        $this->assertSame(['A-1', 'A-2'], $accountNumbers);
        $this->assertSame('/v1/balances', $http->requests[1][0]);
        $this->assertSame(['page' => 2, 'pageSize' => 1], $http->requests[1][1]);
    }

    public function testBalanceSearchPaginationKeepsPathSegment()
    {
        $http = new FakeHttp([
            [
                'ok' => true,
                'balances' => [['accountNumber' => 'A-1']],
                'meta' => ['page' => 1, 'pages' => 2, 'records' => 2],
            ],
            [
                'ok' => true,
                'balances' => [['accountNumber' => 'A-2']],
                'meta' => ['page' => 2, 'pages' => 2, 'records' => 2],
            ],
        ]);
        $gateway = $this->gatewayWithHttp('Trolley\BalanceGateway', $http);

        $accountNumbers = [];
        foreach ($gateway->search('paypal', ['params' => 'wrong', 'pageSize' => 1]) as $balance) {
            $accountNumbers[] = $balance->accountNumber;
        }

        $this->assertSame(['A-1', 'A-2'], $accountNumbers);
        $this->assertSame('/v1/balances/paypal', $http->requests[1][0]);
        $this->assertSame(['page' => 2, 'pageSize' => 1], $http->requests[1][1]);
    }

    public function testBatchPaymentsPaginationKeepsBatchId()
    {
        $http = new FakeHttp([
            [
                'ok' => true,
                'payments' => [['id' => 'P-1']],
                'meta' => ['page' => 1, 'pages' => 2, 'records' => 2],
            ],
            [
                'ok' => true,
                'payments' => [['id' => 'P-2']],
                'meta' => ['page' => 2, 'pages' => 2, 'records' => 2],
            ],
        ]);
        $gateway = $this->gatewayWithHttp('Trolley\BatchGateway', $http);

        $ids = [];
        foreach ($gateway->payments('B-1', ['batchId' => 'B-wrong', 'pageSize' => 1]) as $payment) {
            $ids[] = $payment->id;
        }

        $this->assertSame(['P-1', 'P-2'], $ids);
        $this->assertSame('/v1/batches/B-1/payments', $http->requests[1][0]);
        $this->assertSame(['page' => 2, 'batchId' => 'B-1', 'pageSize' => 1], $http->requests[1][1]);
    }

    public function testVerificationSearchPaginationKeepsQuery()
    {
        $http = new FakeHttp([
            [
                'ok' => true,
                'verifications' => [['id' => 'V-1']],
                'meta' => ['page' => 1, 'pages' => 2, 'records' => 2],
            ],
            [
                'ok' => true,
                'verifications' => [['id' => 'V-2']],
                'meta' => ['page' => 2, 'pages' => 2, 'records' => 2],
            ],
        ]);
        $gateway = $this->gatewayWithHttp('Trolley\VerificationGateway', $http);

        $ids = [];
        foreach ($gateway->search(['search' => 'Jane', 'pageSize' => 1]) as $verification) {
            $ids[] = $verification['id'];
        }

        $this->assertSame(['V-1', 'V-2'], $ids);
        $this->assertSame('/v1/verifications', $http->requests[1][0]);
        $this->assertSame(['page' => 2, 'search' => 'Jane', 'pageSize' => 1], $http->requests[1][1]);
    }

    public function testVerificationMutationCollectionDoesNotPageThroughSearch()
    {
        $http = new FakeHttp([
            [
                'ok' => true,
                'verifications' => [['id' => 'V-1']],
                'meta' => ['page' => 1, 'pages' => 3, 'records' => 2],
            ],
        ]);
        $gateway = $this->gatewayWithHttp('Trolley\VerificationGateway', $http);

        $ids = [];
        foreach ($gateway->triggerWatchlist(['recipientId' => 'R-1']) as $verification) {
            $ids[] = $verification['id'];
        }

        $this->assertSame(['V-1'], $ids);
        $this->assertSame([['post', '/v1/verifications/watchlist/trigger', ['recipientId' => 'R-1']]], $http->requests);
    }

    private function attributesFor($model)
    {
        $property = new ReflectionProperty($model, '_attributes');
        $property->setAccessible(true);
        return $property->getValue($model);
    }

    private function gatewayWithHttp($className, $http)
    {
        $reflection = new ReflectionClass($className);
        $gateway = $reflection->newInstanceWithoutConstructor();
        $property = new ReflectionProperty($className, '_http');
        $property->setAccessible(true);
        $property->setValue($gateway, $http);
        return $gateway;
    }
}

class FakeHttp
{
    public $requests = [];
    private $responses;

    public function __construct($responses)
    {
        $this->responses = $responses;
    }

    public function get($path, $query = null)
    {
        $this->requests[] = [$path, $query];
        return array_shift($this->responses);
    }

    public function post($path, $body = null)
    {
        $this->requests[] = ['post', $path, $body];
        return array_shift($this->responses);
    }
}
