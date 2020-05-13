<?php

namespace Cloudmazing\Tikkie\Controllers;

use App\Http\Controllers\Controller;
use Cloudmazing\Tikkie\Events\TikkiePaymentEvent;
use Cloudmazing\Tikkie\Events\TikkieRefundEvent;
use Cloudmazing\Tikkie\Notification\BaseNotification;
use Cloudmazing\Tikkie\Notification\PaymentNotification;
use Cloudmazing\Tikkie\Notification\RefundNotification;

/**
 * Class TikkieNotificationController.
 *
 * @category Controller
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class TikkieNotificationController extends Controller
{
    /**
     * Triggered upon receiving a notification.
     */
    public function notification()
    {
        try {
            // Get the requestParamets
            $requestParameters = request()->all();

            // Check if we have a notificationType
            if (isset($requestParameters['notificationType'])) {
                //Create the corresponding event
                switch ($requestParameters['notificationType']) {
                    case BaseNotification::NOTIFICATION_TYPE_PAYMENT:
                        // Create the payment event
                        $paymentNotification = new PaymentNotification($requestParameters);
                        event(new TikkiePaymentEvent($paymentNotification));
                        break;
                    case BaseNotification::NOTIFICATION_TYPE_REFUND:
                        // Create the refund event
                        $refundNotification = new RefundNotification($requestParameters);
                        event(new TikkieRefundEvent($refundNotification));
                        break;
                }
            }
        } catch (\Exception $e) {
        }
    }
}
