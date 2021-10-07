<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class PaymentItem.
 *
 * @category Request
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentItem extends BaseRequest
{
    /**
     * Token identifying the payment request.
     *
     * @var string
     */
    protected string $paymentRequestToken;

    /**
     * Token identifying the payment.
     *
     * @var string
     */
    protected string $paymentToken;

    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return self::PAYMENT_REQUESTS.
            "/{$this->getPaymentRequestToken()}".
            "/payments/{$this->getPaymentToken()}";
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

    /**
     * Set the payment token.
     *
     * @param  string  $paymentToken
     */
    public function setPaymentToken(string $paymentToken): void
    {
        $this->paymentToken = $paymentToken;
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
     * Set the payment request token.
     *
     * @param  string  $paymentRequestToken
     */
    public function setPaymentRequestToken(string $paymentRequestToken): void
    {
        $this->paymentRequestToken = $paymentRequestToken;
    }
}
