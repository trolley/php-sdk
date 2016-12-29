# PaymentRails\Client\BatchApi

All URIs are relative to *https://api.paymentrails.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getBatch**](BatchApi.md#getBatch) | **GET** /batches/{batchId} | 
[**startProcessingBatch**](BatchApi.md#startProcessingBatch) | **POST** /batches/{batchId}/start-processing | 
[**updateBatch**](BatchApi.md#updateBatch) | **PATCH** /batches/{batchId} | 


# **getBatch**
> \PaymentRails\Client\Model\Batch getBatch($batch_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BatchApi();
$batch_id = "batch_id_example"; // string | B-XXXXXXXXXXXXXXXX

try {
    $result = $api_instance->getBatch($batch_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BatchApi->getBatch: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **batch_id** | **string**| B-XXXXXXXXXXXXXXXX |

### Return type

[**\PaymentRails\Client\Model\Batch**](../Model/Batch.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **startProcessingBatch**
> \PaymentRails\Client\Model\Batch startProcessingBatch($batch_id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BatchApi();
$batch_id = "batch_id_example"; // string | P-XXXXXXXXXXXXX

try {
    $result = $api_instance->startProcessingBatch($batch_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BatchApi->startProcessingBatch: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **batch_id** | **string**| P-XXXXXXXXXXXXX |

### Return type

[**\PaymentRails\Client\Model\Batch**](../Model/Batch.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateBatch**
> \PaymentRails\Client\Model\Batch updateBatch($batch_id, $body)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BatchApi();
$batch_id = "batch_id_example"; // string | B-XXXXXXXXXXXXXXXX
$body = new \PaymentRails\Client\Model\BatchUpdate(); // \PaymentRails\Client\Model\BatchUpdate | 

try {
    $result = $api_instance->updateBatch($batch_id, $body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BatchApi->updateBatch: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **batch_id** | **string**| B-XXXXXXXXXXXXXXXX |
 **body** | [**\PaymentRails\Client\Model\BatchUpdate**](../Model/\PaymentRails\Client\Model\BatchUpdate.md)|  |

### Return type

[**\PaymentRails\Client\Model\Batch**](../Model/Batch.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

