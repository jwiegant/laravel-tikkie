<?php

namespace Cloudmazing\Tikkie\Notification;

/**
 * Class PaymentNotification.
 *
 * @category Notification
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
    protected string $subscriptionId;

    /**
     * Type of notification. Value should be 'PAYMENT'.
     *
     * @var string
     */
    protected string $notificationType;

    /**
     * Unique token identifying the payment request.
     *
     * @var string
     */
    protected string $paymentRequestToken;

    /**
     * Unique token identifying the payment.
     *
     * @var string Payment Token
     */
    protected string $paymentToken;

    /**
     * Get the subscriptionn id.
     *
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    /**
     * Get the notification type.
     *
     * @return string
     */
    public function getNotificationType(): string
    {
        return $this->notificationType;
    }

    /**
     * Get the payment request token.
     *
     * @return string
     */
    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    /**
     * Get the payment token.
     *
     * @return string
     */
    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }
}
