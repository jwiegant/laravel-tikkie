# Application
###### ABN-AMRO Tikkie v2 Laravel integration
[General](Tikkie.md) |
**Application** |
[Subscription](Subscription.md)  | 
[PaymentRequest](PaymentRequest.md) |
[Payment](Payment.md) | 
[Refund](Refund.md) |
[Example](Example.md)
___
### Create an application
> This can only be use in the sandbox environment. 

```php
$tikkie->application()->create();
```

#### Response

| Method | Description |
| ------ | ----------- |
| getAppToken() | `appToken` to use in other requests. |



