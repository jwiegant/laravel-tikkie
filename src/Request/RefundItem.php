<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class RefundItem.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class RefundItem extends BaseRequest
{
    /**
     * Token identifying the payment request.
     *
     * @var string
     */
    protected $paymentRequestToken;

    /**
     * Token identifying the payment.
     *
     * @var string
     */
    protected $paymentToken;

    /**
     * Token identifying the refund.
     *
     * @var string
     */
    protected $refundToken;

    /**
     * Get the refund token.
     *
     * @return string
     */
    public function getRefundToken(): string
    {
        return $this->refundToken;
    }

    /**
     * Set the refund token.
     *
     * @param  string  $refundToken
     */
    public function setRefundToken(string $refundToken): void
    {
        $this->refundToken = $refundToken;
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
