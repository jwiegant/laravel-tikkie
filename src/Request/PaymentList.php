<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class PaymentList
 *
 * @category Request
 * @package  Cloudmazing\Tikkie\Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentList extends BaseRequestList
{
    /**
     * Payment request token
     *
     * @var string
     */
    protected $paymentRequestToken;

    /**
     * Get the payment request token
     *
     * @return string
     */
    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    /**
     * Set the payment request token
     *
     * @param  string  $paymentRequestToken
     */
    public function setPaymentRequestToken(string $paymentRequestToken): void
    {
        $this->paymentRequestToken = $paymentRequestToken;
    }

}
