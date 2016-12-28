# PaymentOut

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | P-XXXXXXXXXXXXXXXX | [optional] 
**source_amount** | **float** |  | [optional] 
**source_currency** | **string** | source currency code | [optional] 
**source_currency_name** | **string** | currency name | [optional] 
**target_amount** | **float** |  | [optional] 
**target_currency** | **string** | target currency code 3 letters ISO code | [optional] 
**target_currency_name** | **string** | currency name | [optional] 
**recipient_fees** | **float** |  | [optional] 
**fx_rate** | **float** |  | [optional] 
**memo** | **string** |  | [optional] 
**status** | **string** |  | [optional] 
**merchant_fees** | **float** |  | [optional] 
**recipient** | [**\Swagger\Client\Model\PaymentRecipient**](PaymentRecipient.md) |  | [optional] 
**compliance** | [**\Swagger\Client\Model\PaymentComplianceStatus**](PaymentComplianceStatus.md) |  | [optional] 
**batch** | [**\Swagger\Client\Model\PaymentBatch**](PaymentBatch.md) |  | [optional] 
**processed_at** | **string** | processing date | [optional] 
**updated_at** | **string** | last update date | [optional] 
**created_at** | **string** | creation date | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


