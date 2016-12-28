# Swagger\Client\UtilsApi

All URIs are relative to *http://api.railz.io/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getCurrency**](UtilsApi.md#getCurrency) | **GET** /v1/forex/currencies/{currencyCode} | 
[**queryCurrencies**](UtilsApi.md#queryCurrencies) | **GET** /v1/forex/currencies | 


# **getCurrency**
> \Swagger\Client\Model\Currency getCurrency($currency_code)



Returns currency

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new Swagger\Client\Api\UtilsApi();
$currency_code = "currency_code_example"; // string | 2 letters ISO country code

try {
    $result = $api_instance->getCurrency($currency_code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UtilsApi->getCurrency: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **currency_code** | **string**| 2 letters ISO country code |

### Return type

[**\Swagger\Client\Model\Currency**](../Model/Currency.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **queryCurrencies**
> \Swagger\Client\Model\Currency[] queryCurrencies()



Returns currencies

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new Swagger\Client\Api\UtilsApi();

try {
    $result = $api_instance->queryCurrencies();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UtilsApi->queryCurrencies: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Swagger\Client\Model\Currency[]**](../Model/Currency.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

