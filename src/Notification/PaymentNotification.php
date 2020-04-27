<?php

namespace Cloudmazing\Tikkie\Notification;

/**
 * Class PaymentNotification.
 *
 * @category Notification
 * @package Cloudmazing\Tikkie\Notification
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentNotification extends BaseNotification
{
    /**
     * Unique ID that identifies a subscription that has sent a notification.
     *
     * @var string
     */
    protected $subscriptionId;

    /**
     * Type of notification. Value should be 'PAYMENT'.
     *
     * @var string
     */
    protected $notificationType;

    /**
     * Unique token identifying the payment request.
     *
     * @var string
     */
    protected $paymentRequestToken;

    /**
     * Unique token identifying the payment.
     *
     * @var string Payment Token
     */
    protected $paymentToken;
}
