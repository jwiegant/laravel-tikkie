# Subscription
###### ABN-AMRO Tikkie v2 Laravel integration
[General](Tikkie.md) |
[Application](Application.md) |
**Subscription** | 
[PaymentRequest](PaymentRequest.md) |
[Payment](Payment.md) |
[Refund](Refund.md) |
[Example](Example.md)
___
### Create a subscription
> The application must have payment permission to complete this request.

```php
$tikkie->subscription()->create($url);
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| url | string | URL for the payment notification. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getSubscriptionId() | string | Consumer key which is obtained after app registration on the ABN developer portal. |

### Delete a subscription

```php
$tikkie->subscription()->delete();
```
**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |