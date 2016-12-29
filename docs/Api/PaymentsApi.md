# PaymentRails\Client\PaymentsApi

All URIs are relative to *https://api.paymentrails.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getPayment**](PaymentsApi.md#getPayment) | **GET** /v1/payments/{paymentId} | 
[**queryPayments**](PaymentsApi.md#queryPayments) | **GET** /payments | 


# **getPayment**
> \PaymentRails\Client\Model\PaymentOut getPayment($payment_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\PaymentsApi();
$payment_id = "payment_id_example"; // string | P-XXXXXXXXXXXXXXXX

try {
    $result = $api_instance->getPayment($payment_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->getPayment: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **payment_id** | **string**| P-XXXXXXXXXXXXXXXX |

### Return type

[**\PaymentRails\Client\Model\PaymentOut**](../Model/PaymentOut.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **queryPayments**
> \PaymentRails\Client\Model\InlineResponse2001 queryPayments($page, $page_size, $start_date, $end_date, $status, $country, $recipient, $source_currency, $target_currency)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\PaymentsApi();
$page = 56; // int | page number default 1
$page_size = 56; // int | page size default 100
$start_date = "start_date_example"; // string | filter recipients list by creation date from start date format YYYY-MM-DD
$end_date = "end_date_example"; // string | filter recipients list by creation date to end date format YYYY-MM-DD
$status = "status_example"; // string | filter recipients list by status
$country = "country_example"; // string | filter by 2 letter country code
$recipient = "recipient_example"; // string | filter by recipient ID R-XXXXXXXXXXXXXXXX
$source_currency = "source_currency_example"; // string | filter by source currency 3 letters ISO code
$target_currency = "target_currency_example"; // string | filter by target currency 3 letters ISO code

try {
    $result = $api_instance->queryPayments($page, $page_size, $start_date, $end_date, $status, $country, $recipient, $source_currency, $target_currency);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->queryPayments: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| page number default 1 | [optional]
 **page_size** | **int**| page size default 100 | [optional]
 **start_date** | **string**| filter recipients list by creation date from start date format YYYY-MM-DD | [optional]
 **end_date** | **string**| filter recipients list by creation date to end date format YYYY-MM-DD | [optional]
 **status** | **string**| filter recipients list by status | [optional]
 **country** | **string**| filter by 2 letter country code | [optional]
 **recipient** | **string**| filter by recipient ID R-XXXXXXXXXXXXXXXX | [optional]
 **source_currency** | **string**| filter by source currency 3 letters ISO code | [optional]
 **target_currency** | **string**| filter by target currency 3 letters ISO code | [optional]

### Return type

[**\PaymentRails\Client\Model\InlineResponse2001**](../Model/InlineResponse2001.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

