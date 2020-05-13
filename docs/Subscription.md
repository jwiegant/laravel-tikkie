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
We've implemented a default post route to ```[your_website]/api/tikkie/notification``` which will
generate a Payment or Refund Event based on what's posted. 

To use this route also add to your .env file, but you can always use your own route if you want.  
```bash
TIKKIE_ADD_ROUTE=true
```     

```php
$tikkie->subscription()->create('https://[your_website]/api/tikkie/notification');
```

**Input**

| Variable | Type | Description |
| -------- | ---- | ----------- |
| url | string | URL for the payment notification. |

**Response**

| Method | Type | Description |
| ------ | ---- | ----------- |
| getSubscriptionId() | string | Consumer key which is obtained after app registration on the ABN developer portal. |

#### Listeners ####
When the application receives a notification (via our own route) an event will bee generated based on the input. 
To listen and react to this event you need to create the corresponding listeners and implement your own business logic.
 
```bash
php artisan make:listener TikkiePaymentListener -e \\Cloudmazing\\Tikkie\\Events\\TikkiePaymentEvent
php artisan make:listener TikkieRefundListener -e \\Cloudmazing\\Tikkie\\Events\\TikkieRefundEvent
```

Check if the see the events in the even list.  
```bash
php artisan event:list
```

If the events don't show up in the list, you'll have to either add them:
1. Turn on auto discovery in the EventServiceProvider.
Add the following function in ```app\Providers\EventServiceProvider.php```.
```php
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
```

2. Manually in the ``app\Providers\EventServiceProvider.php```.
```php
protected $listen = [
    Registered::class => [
        SendEmailVerificationNotification::class,
    ],
    Cloudmazing\Tikkie\Events\TikkiePaymentEvent::class => [
        App\Listeners\PaymentListener::class
    ],
    Cloudmazing\Tikkie\Events\TikkieRefundEvent::class => [
        App\Listeners\RefundListener::class
    ],
];
```

You can implement the business logic to handle the listener handle function.  

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