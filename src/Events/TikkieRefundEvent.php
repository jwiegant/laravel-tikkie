<?php

namespace Cloudmazing\Tikkie\Events;

use Cloudmazing\Tikkie\Notification\RefundNotification;
use Illuminate\Queue\SerializesModels;

/**
 * Class RefundNotificationEvent.
 *
 * @category Event
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class TikkieRefundEvent
{
    use SerializesModels;

    /**
     * Refund Notification.
     *
     * @var RefundNotification
     */
    public RefundNotification $refundNotification;

    /**
     * Create a new RefundNotificationEven instance.
     *
     * @param RefundNotification $refundNotification
     */
    public function __construct(RefundNotification $refundNotification)
    {
        // Set the refundNotification
        $this->refundNotification = $refundNotification;
    }
}
