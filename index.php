<?php
require_once(__DIR__ . '/SwaggerClient-php/autoload.php');

$apiKey = "pk_test_FEDFD685776134D66BA919735B771CF7";
// Configure API key authorization: merchantKey
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', $apiKey);

$api = new Swagger\Client\Api\RecipientsApi();
// $balancesApi = new Swagger\Client\Api\BalancesApi();
// $batchesApi = new Swagger\Client\Api\BatchesApi();
// $paymentsApi = new Swagger\Client\Api\PaymentsApi();
// $utilsApi = new Swagger\Client\Api\UtilsApi();

// try {
//   $result = $utilsApi->queryCurrencies();
//   print_r($result);
// } catch (Exception $e) {
//   echo "💩 an error occured while querying currencies ", $e->getMessage();
// }
//
// try {
//   $result = $paymentsApi->queryPayments();
//   print_r("payments: ".count($result).PHP_EOL);
//   var_dump($result);
// } catch (Exeception $e) {
//   echo "💩 goot an exception query payments", $e->getMessage();
// }
//
// try{
//   $result = $batchesApi->queryBatches();
//   print_r("Batches: ".count($result).PHP_EOL);
//   var_dump($result);
// } catch (Exeception $e) {
//   echo "💩 goot an exeception querying batches ", $e->getMessage();
// }
//
// try{
//   $result = $balancesApi->queryBalances();
//   var_dump($result);
// } catch (Exception $e) {
//   echo "💩 goot an exeception querying balances ", $e->getMessage();
// }

try {
    echo "Pong";
    $result = $api->queryRecipients();
    var_dump($result);

} catch (Exception $e) {
    echo "💩🐱💩";
    echo 'Exception when calling the api ', $e->getMessage(), PHP_EOL;
}

?>
