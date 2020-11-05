<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class PaymentRequestItem.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequestItem extends BaseRequest
{
    /**
     * Token identifying the payment request.
     *
     * @var string
     */
    protected string $paymentRequestToken;

    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return self::PAYMENT_REQUESTS.
            "/{$this->getPaymentRequestToken()}";
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
