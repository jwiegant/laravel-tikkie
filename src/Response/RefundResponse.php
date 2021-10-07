<?php

namespace Cloudmazing\Tikkie\Response;

use Carbon\Carbon;

/**
 * Class RefundResponse.
 *
 * @category Response
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class RefundResponse extends BaseResponse
{
    /**
     * Constants.
     */
    /**
     * The refund is pending.
     */
    public const STATUS_PENDING = 'PENDING';
    /**
     * The refund has been paid.
     */
    public const STATUS_PAID = 'PAID';

    /**
     * Unique token identifying this refund.
     *
     * @var string
     */
    protected string $refundToken;

    /**
     * Amount of the refund in cents (euros).
     *
     * @var int
     */
    protected int $amountInCents;

    /**
     * Description of the refund.
     *
     * @var string
     */
    protected string $description;

    /**
     * ID for the reference of the API consumer.
     *
     * @var string
     */
    protected string $referenceId;

    /**
     * Timestamp at which the refund was created. Format: YYYY-MM-DDTHH:mm:ss.SSSZ.
     *
     * @var Carbon
     */
    protected Carbon $createdDateTime;

    /**
     * Current status of the refund. Possible values are: 'PENDING', 'PAID'.
     *
     * @var string
     */
    protected string $status;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected array $casts = [
        'createdDateTime' => ['type' => 'carbon'],
    ];

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
     * Get the amount in cents.
     *
     * @return int
     */
    public function getAmountInCents(): int
    {
        return $this->amountInCents;
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
     * Get the description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
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
     * Get the created datetime.
     *
     * @return Carbon
     */
    public function getCreatedDateTime(): Carbon
    {
        return $this->createdDateTime;
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

    /**
     * Has this refund been paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }
}
