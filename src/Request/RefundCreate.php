<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class RefundCreate.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class RefundCreate extends BaseRequest
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
     * Description of the refund. Max length: 35 characters.
     *
     * @var string
     */
    protected string $description;

    /**
     * Amount to refund in cents (euros).
     *
     * @var int
     */
    protected int $amountInCents;

    /**
     * Unique ID reference for the API consumer. Max length: 35 characters.
     *
     * @var string
     */
    protected string $referenceId = 'no reference given';

    /**
     * Parameters to include in the payload.
     *
     * @var array Payload array
     */
    protected array $payload = [
        'description',
        'amountInCents',
        'referenceId',
    ];

    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction()
    {
        return self::PAYMENT_REQUESTS.
            "/{$this->getPaymentRequestToken()}".
            "/payments/{$this->getPaymentToken()}".
            '/refunds';
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
     * @param string $paymentRequestToken
     */
    public function setPaymentRequestToken(string $paymentRequestToken): void
    {
        $this->paymentRequestToken = $paymentRequestToken;
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
     * @param string $paymentToken
     */
    public function setPaymentToken(string $paymentToken): void
    {
        $this->paymentToken = $paymentToken;
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the description.
     *
     * @param  string  $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the amount in cents.
     *
     * @return int
     */
    public function getAmountInCents(): int
    {
        return $this->amountInCents;
    }

    /**
     * Set the amount in cents.
     *
     * @param  int  $amountInCents
     */
    public function setAmountInCents(int $amountInCents): void
    {
        $this->amountInCents = $amountInCents;
    }

    /**
     * Get the reference id.
     *
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    /**
     * Set the reference id.
     *
     * @param  string  $referenceId
     */
    public function setReferenceId(string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }
}
