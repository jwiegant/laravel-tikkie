<?php

namespace Cloudmazing\Tikkie\Response;

use Carbon\Carbon;
use Cloudmazing\Tikkie\Request\RefundItem;
use Illuminate\Support\Collection;

/**
 * Class PaymentResponse.
 *
 * @category Response
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentResponse extends BaseResponse
{
    /**
     * Unique token identifying this payment.
     *
     * @var string
     */
    protected string $paymentToken;

    /**
     * Unique ID identifying this payment. This will be displayed on the payers
     * statement.
     *
     * @var string
     */
    protected string $tikkieId;

    /**
     * Name of the payer.
     *
     * @var string
     */
    protected string $counterPartyName;

    /**
     * IBAN of the payer.
     *
     * @var string
     */
    protected string $counterPartyAccountNumber;

    /**
     * Amount in cents which was paid (euros).
     *
     * @var int
     */
    protected int $amountInCents;

    /**
     * Description of the payment request which the payer or payers will see.
     *
     * @var string
     */
    protected string $description;

    /**
     * Timestamp at which the payment request was created. Format:
     * YYYY-MM-DDTHH:mm:ss.SSSZ.
     *
     * @var Carbon
     */
    protected Carbon $createdDateTime;

    /**
     * Containing all refunds on this payment.
     *
     * @var Collection<RefundItem>
     */
    protected Collection $refunds;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected array $casts = [
        'createdDateTime' => ['type' => 'carbon'],
        'refunds'         => ['type'  => 'collection',
            'class' => RefundResponse::class,
        ],
    ];

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
     * Get the tikkie id.
     *
     * @return string
     */
    public function getTikkieId(): string
    {
        return $this->tikkieId;
    }

    /**
     * Get the counter party name.
     *
     * @return string
     */
    public function getCounterPartyName(): string
    {
        return $this->counterPartyName;
    }

    /**
     * Get the counter party account number.
     *
     * @return string
     */
    public function getCounterPartyAccountNumber(): string
    {
        return $this->counterPartyAccountNumber;
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
     * Get the description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
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
     * Get the collection of refunds.
     *
     * @return Collection
     */
    public function getRefunds(): Collection
    {
        return $this->refunds;
    }
}
