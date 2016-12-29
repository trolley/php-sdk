# PaymentRails\Client\RecipientsApi

All URIs are relative to *https://api.paymentrails.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createRecipient**](RecipientsApi.md#createRecipient) | **POST** /recipients | 
[**deleteRecipients**](RecipientsApi.md#deleteRecipients) | **DELETE** /recipients | 
[**exportRecipientCsv**](RecipientsApi.md#exportRecipientCsv) | **GET** /recipients/exports.csv | 
[**queryRecipients**](RecipientsApi.md#queryRecipients) | **GET** /recipients | 
[**uploadRecipientCsv**](RecipientsApi.md#uploadRecipientCsv) | **POST** /recipients/upload | 


# **createRecipient**
> \PaymentRails\Client\Model\InlineResponse2003 createRecipient($body)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\RecipientsApi();
$body = new \PaymentRails\Client\Model\RecipientPost(); // \PaymentRails\Client\Model\RecipientPost | 

try {
    $result = $api_instance->createRecipient($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RecipientsApi->createRecipient: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\PaymentRails\Client\Model\RecipientPost**](../Model/\PaymentRails\Client\Model\RecipientPost.md)|  | [optional]

### Return type

[**\PaymentRails\Client\Model\InlineResponse2003**](../Model/InlineResponse2003.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteRecipients**
> deleteRecipients($ids)



Delete multiple recipients

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\RecipientsApi();
$ids = new \PaymentRails\Client\Model\DeleteIds(); // \PaymentRails\Client\Model\DeleteIds | an array of valid recipient's id

try {
    $api_instance->deleteRecipients($ids);
} catch (Exception $e) {
    echo 'Exception when calling RecipientsApi->deleteRecipients: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **ids** | [**\PaymentRails\Client\Model\DeleteIds**](../Model/\PaymentRails\Client\Model\DeleteIds.md)| an array of valid recipient&#39;s id | [optional]

### Return type

void (empty response body)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **exportRecipientCsv**
> exportRecipientCsv($page, $page_size, $start_date, $end_date, $status, $compliance_status, $payout_method, $payout_currency, $country)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\RecipientsApi();
$page = 56; // int | page number default 1
$page_size = 56; // int | page size default 100
$start_date = "start_date_example"; // string | filter recipients list by creation date from start date format YYYY-MM-DD
$end_date = "end_date_example"; // string | filter recipients list by creation date to end date format YYYY-MM-DD
$status = "status_example"; // string | filter recipients list by status
$compliance_status = "compliance_status_example"; // string | filter recipients list by compliance status
$payout_method = "payout_method_example"; // string | filter recipients list by payout methods
$payout_currency = "payout_currency_example"; // string | filter recipients list by payout currency 3 letters ISO code
$country = "country_example"; // string | filter recipients list by country

try {
    $api_instance->exportRecipientCsv($page, $page_size, $start_date, $end_date, $status, $compliance_status, $payout_method, $payout_currency, $country);
} catch (Exception $e) {
    echo 'Exception when calling RecipientsApi->exportRecipientCsv: ', $e->getMessage(), PHP_EOL;
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
 **compliance_status** | **string**| filter recipients list by compliance status | [optional]
 **payout_method** | **string**| filter recipients list by payout methods | [optional]
 **payout_currency** | **string**| filter recipients list by payout currency 3 letters ISO code | [optional]
 **country** | **string**| filter recipients list by country | [optional]

### Return type

void (empty response body)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: text/csv

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **queryRecipients**
> \PaymentRails\Client\Model\InlineResponse2002 queryRecipients($page, $page_size, $start_date, $end_date, $status, $compliance_status, $payout_method, $payout_currency, $country)



Return recipients

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\RecipientsApi();
$page = 56; // int | page number default 1
$page_size = 56; // int | page size default 100
$start_date = "start_date_example"; // string | filter recipients list by creation date from start date format YYYY-MM-DD
$end_date = "end_date_example"; // string | filter recipients list by creation date to end date format YYYY-MM-DD
$status = "status_example"; // string | filter recipients list by status multiple values separated by coma
$compliance_status = "compliance_status_example"; // string | filter recipients list by compliance status multiple values separated by comas
$payout_method = "payout_method_example"; // string | filter recipients list by payout methods multiple values separated by comas
$payout_currency = "payout_currency_example"; // string | filter recipients list by payout currency 3 letters ISO code, multiple values separated by comas
$country = "country_example"; // string | filter recipients list by country multiple values separated by comas

try {
    $result = $api_instance->queryRecipients($page, $page_size, $start_date, $end_date, $status, $compliance_status, $payout_method, $payout_currency, $country);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RecipientsApi->queryRecipients: ', $e->getMessage(), PHP_EOL;
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
 **status** | **string**| filter recipients list by status multiple values separated by coma | [optional]
 **compliance_status** | **string**| filter recipients list by compliance status multiple values separated by comas | [optional]
 **payout_method** | **string**| filter recipients list by payout methods multiple values separated by comas | [optional]
 **payout_currency** | **string**| filter recipients list by payout currency 3 letters ISO code, multiple values separated by comas | [optional]
 **country** | **string**| filter recipients list by country multiple values separated by comas | [optional]

### Return type

[**\PaymentRails\Client\Model\InlineResponse2002**](../Model/InlineResponse2002.md)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **uploadRecipientCsv**
> uploadRecipientCsv($file)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: merchantKey
PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKey('x-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// PaymentRails\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-api-key', 'Bearer');

$api_instance = new PaymentRails\Client\Api\RecipientsApi();
$file = "/path/to/file.txt"; // \SplFileObject | the csv file

try {
    $api_instance->uploadRecipientCsv($file);
} catch (Exception $e) {
    echo 'Exception when calling RecipientsApi->uploadRecipientCsv: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **file** | **\SplFileObject**| the csv file |

### Return type

void (empty response body)

### Authorization

[merchantKey](../../README.md#merchantKey)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

