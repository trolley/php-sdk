# PaymentRails\Client\BatchesApi

All URIs are relative to *http://api.railz.io/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createBatch**](BatchesApi.md#createBatch) | **POST** /batches | 
[**queryBatches**](BatchesApi.md#queryBatches) | **GET** /batches | 


# **createBatch**
> \PaymentRails\Client\Model\Batch createBatch($body)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BatchesApi();
$body = new \PaymentRails\Client\Model\BatchPost(); // \PaymentRails\Client\Model\BatchPost | B-XXXXXXXXXXXXXXXX

try {
    $result = $api_instance->createBatch($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BatchesApi->createBatch: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\PaymentRails\Client\Model\BatchPost**](../Model/\PaymentRails\Client\Model\BatchPost.md)| B-XXXXXXXXXXXXXXXX |

### Return type

[**\PaymentRails\Client\Model\Batch**](../Model/Batch.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **queryBatches**
> \PaymentRails\Client\Model\InlineResponse200 queryBatches($start_date, $end_date, $status)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\BatchesApi();
$start_date = "start_date_example"; // string | 
$end_date = "end_date_example"; // string | 
$status = "status_example"; // string | filter one or more status. multiple value comma separated

try {
    $result = $api_instance->queryBatches($start_date, $end_date, $status);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BatchesApi->queryBatches: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **start_date** | **string**|  | [optional]
 **end_date** | **string**|  | [optional]
 **status** | **string**| filter one or more status. multiple value comma separated | [optional]

### Return type

[**\PaymentRails\Client\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

