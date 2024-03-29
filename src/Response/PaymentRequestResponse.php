<?php

namespace Cloudmazing\Tikkie\Response;

use Carbon\Carbon;

/**
 * Class PaymentRequestResponse.
 *
 * @category Response
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequestResponse extends BaseResponse
{
    /**
     * Constants.
     */
    /**
     * A payment request is open and ready to be paid.
     */
    public const OPEN = 'OPEN';
    /**
     * A payment request is closed.
     */
    public const CLOSED = 'CLOSED';
    /**
     * A payment request has expired.
     * The default expiry period is 14 days. You can customize this when you start
     * using the Payment Request API in production.
     */
    public const EXPIRED = 'EXPIRED';
    /**
     * The payment request has reached its maximum amount in Euro. This limit is
     * dependent on the agreed maximum amount.
     */
    /**
     * The payment request has reached its maximum amount of payments. The maximum
     * amount of payments per request can be set to one or unlimited.
     */
    public const MAX_SUCCESSFUL_PAYMENTS_REACHED = 'MAX_SUCCESSFUL_PAYMENTS_REACHED';

    /**
     * Unique token identifying this payment request which is later used when
     * retrieving details.
     *
     * @var string
     */
    protected string $paymentRequestToken;

    /**
     * Amount in cents to be paid (euros). Value will not be present for open
     * payment requests.
     *
     * @var int
     */
    protected int $amountInCents;

    /**
     * ID for the reference of the API consumer.
     *
     * @var string
     */
    protected string $referenceId;

    /**
     * Description of the payment request which the payer or payers will see.
     *
     * @var string
     */
    protected string $description;

    /**
     * URL where the payment request can be paid.
     *
     * @var string
     */
    protected string $url;

    /**
     * Date after which the payment request will expire and cannot be paid. Format
     * is yyyy-mm-dd.
     *
     * @var Carbon
     */
    protected Carbon $expiryDate;

    /**
     * Timestamp at which the payment request was created. Format:
     * YYYY-MM-DDTHH:mm:ss.SSSZ.
     *
     * @var Carbon
     */
    protected Carbon $createdDateTime;

    /**
     * Current status of the payment request. Possible values are: 'OPEN', 'CLOSED',
     * 'EXPIRED', 'MAX_YIELD_REACHED', and 'MAX_SUCCESSFUL_PAYMENTS_REACHED'.
     *
     * @var string
     */
    protected string $status;

    /**
     * Number of payments which have been collected on this payment request.
     *
     * @var int
     */
    protected int $numberOfPayments;

    /**
     * Total amount in cents which has been collected on this payment request.
     *
     * @var int
     */
    protected int $totalAmountPaidInCents;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected array $casts = [
        'expiryDate'      => ['type' => 'carbon'],
        'createdDateTime' => ['type' => 'carbon'],
    ];

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
     * Get the amount.
     *
     * @return float
     */
    public function getAmount(): float
    {
        return round($this->getAmountInCents() / 100, 2);
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
     * Get the reference id.
     *
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
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
     * Get the payment url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the expiry date.
     *
     * @return Carbon
     */
    public function getExpiryDate(): Carbon
    {
        return $this->expiryDate;
    }

    /**
     * Get the creation date.
     *
     * @return Carbon
     */
    public function getCreatedDateTime(): Carbon
    {
        return $this->createdDateTime;
    }

    /**
     * Get the number of payments.
     *
     * @return int
     */
    public function getNumberOfPayments(): int
    {
        return $this->numberOfPayments;
    }

    /**
     * Get the amount paid in cents.
     *
     * @return int
     */
    public function getTotalAmountPaidInCents(): int
    {
        return $this->totalAmountPaidInCents;
    }

    /**
     * Get the amount paid.
     *
     * @return float
     */
    public function getTotalAmountPaid(): float
    {
        return round($this->totalAmountPaidInCents / 100, 2);
    }

    /**
     * Is the payment request open.
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->getStatus() === self::OPEN;
    }

    /**
     * Get the status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
