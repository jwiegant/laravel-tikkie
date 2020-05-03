# Example Application
###### ABN-AMRO Tikkie v2 Laravel integration
[General](Tikkie.md) |
[Application](Application.md) |
[Subscription](Subscription.md) | 
[PaymentRequest](PaymentRequest.md) |
[Payment](Payment.md) | 
[Refund](Refund.md) |
**Example**
___
### Follow these steps to create a working example application

*  Create a new laravel application. 
```bash
laravel new laravel-tikkie-example
```
> If you don't have laravel cli installed, then checkout the [laravel installation documentation](https://laravel.com/docs/7.x/installation).

* Enter the directory.
```bash
cd laravel-tikkie-example
```

* Install the laravel-tikkie package.
```bash
composer require jwiegant/laravel-tikkie
```

* Publish the tikkie configuration.
```bash
php artisan vendor:publish --tag=tikkie-config
```

* Edit your `.env` file and add the Tikkie information.

For this example we'll use the sandbox, insert your own api key. 
Which can be found under [**My Apps** in your account](https://developer.abnamro.com/api/tikkie-v2/tutorial).    
```env
TIKKIE_SANDBOX=true
TIKKIE_API_KEY=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
TIKKIE_APP_TOKEN=XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX
```

> **Important**: In a production environment, App token is created in the Tikkie Business Portal.
  
* Open `routes/web.php` and at the top the use statement. 
```php
use Cloudmazing\Tikkie\Tikkie;
```

* Add in `routes/web.php` the following application creation route at the bottom.     
```php
Route::get('/tikkie-application', function(Tikkie $tikkie) {
    $application = $tikkie->application()->create();

    dd($application);
});
```

* Start the your laravel app with `php artisen serve`, open your browser and point it 
to `http://127.0.0.1:8000/tikkie-application`.

If you've done all the step, you'll get a appToken in the response. If you get an error, 
please read it carefully and review the steps above.

```php
Cloudmazing\Tikkie\Response\ApplicationResponse {#259 ▼
  #appToken: "c5d814ab-bbf7-4cac-8387-7cd24c3dd4fc"
  #casts: []
}
```

* Enter the `appToken` in your `.env` file.

> **Important**: Restart your laravel application, otherwise your added app token
> won't be used.  

* Add in `routes/web.php` the following payment request route at the bottom.     
```php
Route::get('/tikkie-create', function(Tikkie $tikkie) {
    // Set your description.
    $description = 'Example description';

    // Set your reference, this can be anything. Commonly you would use
    // something like an OrderId. 
    $reference = 'MyReference';

    // The amount that has to be paid. 
    $amount = 12.50;

    // Date after which the payment request will expire and cannot be paid.
    $expiryDate = Carbon::now()->addDays(7);

    // Create the request
    $request = $tikkie->paymentRequest()->create($description, $reference,
        $expiryDate, $amount);
    
    // Redirect the user to the payment Url.
    return redirect($request->getUrl());
});
```

* Point your browser to `http://127.0.0.1:8000/tikkie-create`. A Tikkie payment will 
be created and you'll be redirected to the Tikkie payment page. 

**This concludes our little example.** 