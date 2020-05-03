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
     * Include refunds in the response.
     *
     * @var bool
     */
    protected bool $includeRefunds;

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

        // Add payment request token and include refunds to the payload.
        $this->payload[] = 'paymentRequestToken';
        $this->payload[] = 'includeRefunds';

        // Add include refunds to the casts array.
        $this->casts['includeRefunds'] = [
            'type' => 'bool',
        ];
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

    /**
     * Set if we want to include refunds.
     *
     * @param  bool  $includeRefunds
     */
    public function setIncludeRefunds(bool $includeRefunds): void
    {
        $this->includeRefunds = $includeRefunds;
    }

    /**
     * Do we want to include refunds?
     *
     * @return bool
     */
    public function isIncludeRefunds(): bool
    {
        return $this->includeRefunds;
    }
}
