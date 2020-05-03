# Application
###### ABN-AMRO Tikkie v2 Laravel integration
**General** |
[Application](Application.md) |
[Subscription](Subscription.md)
[PaymentRequest](PaymentRequest.md) |
[Payment](Payment.md) | 
[Refund](Refund.md) |
[Example](Example.md)
___
### General
There are several ways to get the `Tikkie` object.  

##### Facade
```php
$tikkie = app('tikkie');
$tikkie->....
```

##### Dependency Injection
```php
class Example {
    function show(Tikkie $tikkie) {
        $tikkie->....
    }   
}
```
 