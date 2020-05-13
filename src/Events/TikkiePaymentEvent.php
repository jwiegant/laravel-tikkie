<?php

namespace Cloudmazing\Tikkie\Events;

use Cloudmazing\Tikkie\Notification\PaymentNotification;
use Illuminate\Queue\SerializesModels;

/**
 * Class PaymentNotificationEvent.
 *
 * @category Event
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class TikkiePaymentEvent
{
    use SerializesModels;

    /**
     * Payment Notification.
     *
     * @var PaymentNotification
     */
    public PaymentNotification $paymentNotification;

    /**
     * Create a new event instance.
     *
     * @param  PaymentNotification  $paymentNotification
     */
    public function __construct(PaymentNotification $paymentNotification)
    {
        // Set the paymentNotification
        $this->paymentNotification = $paymentNotification;
    }
}
