<?php

namespace Cloudmazing\Tikkie\Facades;

use Cloudmazing\Tikkie\Application;
use Cloudmazing\Tikkie\Payment;
use Cloudmazing\Tikkie\PaymentRequest;
use Cloudmazing\Tikkie\Refund;
use Cloudmazing\Tikkie\Subscription;
use Illuminate\Support\Facades\Facade;

/**
 * Class Tikkie.
 *
 * @package Cloudmazing\Tikkie\Facades
 *
 * @method static Application application()
 * @method static Payment payment()
 * @method static PaymentRequest paymentRequest()
 * @method static Refund refund()
 * @method static Subscription subscription()
 *
 * @see \Cloudmazing\Tikkie\Tikkie
 */
class Tikkie extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tikkie';
    }
}
