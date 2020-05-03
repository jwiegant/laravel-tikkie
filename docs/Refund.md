# Refund
###### ABN-AMRO Tikkie v2 Laravel integration
[General](Tikkie.md) |
[Application](Application.md) |
[Subscription](Subscription.md) | 
[PaymentRequest](PaymentRequest.md) |
[Payment](Payment.md) |
**Refund** |
[Example](Example.md)
___
### Refund status values
| Status | Description |
| ------ | ----------- |
| PENDING | The refund has been scheduled and will be completed as soon as there is enough money in the account. If there is not enough money in the account on a particular day, the refund will be carried over to the next day and completed when the amount is available. The refund will remain in a scheduled state indefinitely until the amount is available and the refund is executed. |
| PAID | The refund has been paid out. | 

### Create a refund
```php
$tikkie->refund()->create(
    $paymentRequestToken, 
    $paymentToken, 
    $description,
    $amount, 
    $referenceId
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| paymentRequestToken | string | Token identifying the payment request. |
| paymentToken | string | Token identifying the payment. |
| description | string | 	Description of the refund. Max length: 35 characters. |
| amount | float | Amount to refund (euros). |
| referenceId | string | Unique ID reference for the API consumer. Max length: 35 characters. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getRefundToken() | string | Unique token identifying this refund. |
| getAmountInCents() | int | Amount of the refund in cents (euros). |
| getAmount() | float | Amount of the refund (euros). |
| getDescription() | string | Description of the refund. |
| getReferenceId() | string | Unique ID reference for the API consumer. |
| getCreatedDateTime() | Carbon | Timestamp at which the refund was created. |
| getStatus() | string | Current status of the refund. Possible values are: 'PENDING', 'PAID'. |
| isPaid() | bool | Is the refund been paid. |

### Get a refund
```php
$tikkie->refund()->get(
    $paymentRequestToken, 
    $paymentToken, 
    $refundToken
);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| paymentRequestToken | string | Token identifying the payment request. |
| paymentToken | string | Token identifying the payment. |
| refundToken | string | 	Token identifying the refund. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getRefundToken() | string | Unique token identifying this refund. |
| getAmountInCents() | int | Amount of the refund in cents (euros). |
| getAmount() | float | Amount of the refund (euros). |
| getDescription() | string | Description of the refund. |
| getReferenceId() | string | Unique ID reference for the API consumer. |
| getCreatedDateTime() | Carbon | Timestamp at which the refund was created. |
| getStatus() | string | Current status of the refund. Possible values are: 'PENDING', 'PAID'. |
| isPaid() | bool | Is the refund been paid. |