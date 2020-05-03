# Payment
###### ABN-AMRO Tikkie v2 Laravel integration
[General](Tikkie.md) |
[Application](Application.md) |
[Subscription](Subscription.md) | 
[PaymentRequest](PaymentRequest.md) |
**Payment** | 
[Refund](Refund.md) |
[Example](Example.md)
___
### List payments
```php
$tikkie->payment()->list(
    $paymentRequestToken,
    $includeRefunds,
    $pageNumber,
    $pageSize,
    $fromDateTime,
    $toDateTime
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| paymentRequestToken | string | Token identifying the payment request. | 
| includeRefunds | bool | Include refunds in the response. Default false | 
| pageNumber | int | Number of the page to be returned. Starts at zero. Default 0. |  
| pageSize | int | 	Number of items on a page. Range: 1-50. Default 50. |
| fromDateTime | Carbon | Point in time where to start searching for items. Default empty. |
| toDateTime | Carbon | Point in time where to stop searching for items. Default empty. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getPayments() | Collection | Collection containing all payments which match the specified criteria. |
| getTotalElementCount() | int | Returns the number of elements in the collection. |

### Get a payment 
```php
$tikkie->payment()->get(
    $paymentRequestToken,
    $paymentToken
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| paymentRequestToken | string | Token identifying the payment request. |
| paymentToken | string | Token identifying the payment. |  

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getPaymentToken() | string | 	Unique token identifying this payment. |
| getTikkieId() | string | Unique ID identifying this payment. This will be displayed on the payers statement. | 
| getCounterPartyName() | string | Name of the payer. |
| getCounterPartyAccountNumber() | string | IBAN of the payer. | 
| getAmountInCents() | int | Amount in cents which was paid (euros). |
| getAmount() | float | Amount which was paid (euros). |
| getDescription() | string | Description of the payment request which the payer or payers will see. |
| getCreatedDateTime() | Carbon | Timestamp at which the payment request was created. |
| getRefunds() | Collection | Collection of [Refunds](Refund.md). |
