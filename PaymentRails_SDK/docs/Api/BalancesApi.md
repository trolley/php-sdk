# PaymentRails\Client\BalancesApi

All URIs are relative to *http://api.railz.io/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getPaymentrails**](BalancesApi.md#getPaymentrails) | **GET** /v1/profile/balances/paymentrails | 
[**getPaypal**](BalancesApi.md#getPaypal) | **GET** /v1/profile/balances/paypal | 
[**queryBalances**](BalancesApi.md#queryBalances) | **GET** /v1/profile/balances | 


# **getPaymentrails**
> \PaymentRails\Client\Model\Balance getPaymentrails()



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BalancesApi();

try {
    $result = $api_instance->getPaymentrails();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BalancesApi->getPaymentrails: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\PaymentRails\Client\Model\Balance**](../Model/Balance.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getPaypal**
> \PaymentRails\Client\Model\Balance getPaypal()



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BalancesApi();

try {
    $result = $api_instance->getPaypal();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BalancesApi->getPaypal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\PaymentRails\Client\Model\Balance**](../Model/Balance.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **queryBalances**
> \PaymentRails\Client\Model\Balance[] queryBalances()



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BalancesApi();

try {
    $result = $api_instance->queryBalances();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BalancesApi->queryBalances: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\PaymentRails\Client\Model\Balance[]**](../Model/Balance.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

