<?php

namespace Cloudmazing\Tikkie\Request;

use Exception;

/**
 * Class PaymentList.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentList extends BaseRequestList
{
    /**
     * Payment request token.
     *
     * @var string
     */
    protected string $paymentRequestToken;

    /**
     * PaymentList constructor.
     *
     * @param  array|null  $parameters
     *
     * @throws Exception
     */
    public function __construct(array $parameters = null)
    {
        parent::__construct($parameters);

        // Add the payment request token to the payload
        $this->payload[] = 'paymentRequestToken';
    }

    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction()
    {
        return self::PAYMENT_REQUESTS.
            "/{$this->getPaymentRequestToken()}/payments";
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
