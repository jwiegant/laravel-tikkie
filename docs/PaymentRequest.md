# PaymentRequest
###### ABN-AMRO Tikkie v2 Laravel integration
[General](Tikkie.md) |
[Application](Application.md) |
[Subscription](Subscription.md) | 
**PaymentRequest** |
[Payment](Payment.md) |
[Refund](Refund.md) |
[Example](Example.md)
___
### Payment status values
| Status | Description |
| ------ | ----------- |
| OPEN | A payment request is open and ready to be paid. |
| CLOSED | A payment request is closed. |
| EXPIRED | The default expiry period is 14 days. You can customize this when you start using the Payment Request API in production. |
| MAX_YIELD_REACHED | The payment request has reached its maximum amount in Euro. This limit is dependent on the agreed maximum amount. |
| MAX_SUCCESSFUL_PAYMENTS_REACHED | The payment request has reached its maximum amount of payments. The maximum amount of payments per request can be set to one or unlimited. |

### Create a payment request
```php
$tikkie->paymentRequest()->create(
    $description, 
    $referenceId, 
    $expiryDate,
    $amount
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| description | string | Description of the payment request which the payer or payers will see. Max length: 35 characters. |
| referenceId | string | ID for the reference of the API consumer. Max length: 35 characters. |
| expiryDate | Carbon | Date after which the payment request will expire and cannot be paid. If no value is specified, the expiryDate is set to 7 days from now. |
| amount | float | Amount of the payment request (euros). If this value is not specified an open payment request will be created. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getPaymentRequestToken() | string | Unique token identifying this payment request which is later used when retrieving details. |
| getAmountInCents() | int | Amount in cents to be paid (euros). Value will not be present for open payment requests. |
| getAmount() | float | Amount to be paid (euros). Value will not be present for open payment requests. |
| getReferenceId() | string | Unique ID reference for the API consumer. |
| getDescription() | string | Description of the payment request which the payer or payers will see. |
| getUrl() | string | URL where the payment request can be paid. |
| getExpiryDate() | Carbon | Date after which the payment request will expire and cannot be paid. |
| getCreatedDateTime() | Carbon | Timestamp at which the payment request was created. |
| getStatus() | string | Current status of the payment request. Possible values are: 'OPEN', 'CLOSED', 'EXPIRED', 'MAX_YIELD_REACHED', and 'MAX_SUCCESSFUL_PAYMENTS_REACHED'. |
| isOpen() | bool | Is the payment request open for payment. |

### List payment requests
```php
$tikkie->paymentRequest()->list(
    $pageNumber,
    $pageSize,
    $fromDateTime,
    $toDateTime
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| pageNumber | int | Number of the page to be returned. Starts at zero. Default 0. |  
| pageSize | int | 	Number of items on a page. Range: 1-50. Default 50. |
| fromDateTime | Carbon | Point in time where to start searching for items. Default empty. |
| toDateTime | Carbon | Point in time where to stop searching for items. Default empty. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getPaymentRequests() | Collection | Collection containing all payment requests which match the specified criteria. |
| getTotalElementCount() | int | Returns the number of elements in the collection. |

### Get a payment requests
```php
$tikkie->paymentRequest()->get(
    $paymentRequestToken
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| paymentRequestToken | string | Token identifying the payment request. |  

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getPaymentRequestToken() | string | Unique token identifying this payment request which is later used when retrieving details. |
| getAmountInCents() | int | Amount in cents to be paid (euros). Value will not be present for open payment requests. |
| getAmount() | float | Amount to be paid (euros). Value will not be present for open payment requests. |
| getReferenceId() | string | Unique ID reference for the API consumer. |
| getDescription() | string | Description of the payment request which the payer or payers will see. |
| getUrl() | string | URL where the payment request can be paid. |
| getExpiryDate() | Carbon | Date after which the payment request will expire and cannot be paid. |
| getCreatedDateTime() | Carbon | Timestamp at which the payment request was created. |
| getStatus() | string | Current status of the payment request. Possible values are: 'OPEN', 'CLOSED', 'EXPIRED', 'MAX_YIELD_REACHED', and 'MAX_SUCCESSFUL_PAYMENTS_REACHED'. |
| getNumberOfPayments() | int | Number of payments which have been collected on this payment request. | 
| getTotalAmountPaidInCents() | int | Total amount in cents which has been collected on this payment request. |
| getTotalAmountPaid() | float |  Total amount which has been collected on this payment request. | 
| isOpen() | bool | Is the payment request open for payment. |
 
