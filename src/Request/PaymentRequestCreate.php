<?php

namespace Cloudmazing\Tikkie\Request;

use Carbon\Carbon;

/**
 * Class PaymentRequestCreate.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequestCreate extends BaseRequest
{
    /**
     * Constants.
     */
    const PAYMENT_REQUESTS = 'paymentrequests';

    /**
     * Description of the payment request which the payer or payers will see. Max
     * length: 35 characters.
     *
     * @var string
     */
    protected $description;

    /**
     * Amount in cents of the payment request (euros). If this value is not
     * specified an open payment request will be created.
     *
     * @var int
     */
    protected $amountInCents;

    /**
     * Date after which the payment request will expire and cannot be paid. Format
     * is yyyy-mm-dd.
     *
     * @var Carbon
     */
    protected $expiryDate;

    /**
     * ID for the reference of the API consumer. Max length: 35 characters.
     *
     * @var string
     */
    protected $referenceId = 'no reference given';

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected $casts = [
        'expiryDate' => [
            'type' => 'carbon',
            'format' => 'Y-m-d',
            'nullable' => false,
        ],
    ];

    /**
     * Parameters to include in the payload.
     *
     * @var array
     */
    protected $payload = [
        'description',
        'amountInCents',
        'expiryDate',
        'referenceId',
    ];

    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction()
    {
        return self::PAYMENT_REQUESTS;
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
     * Set the amound in cents.
     *
     * @param  int  $amountInCents
     */
    public function setAmountInCents(int $amountInCents): void
    {
        $this->amountInCents = $amountInCents;
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
     * Set the expiry date.
     *
     * @param  Carbon  $expiryDate
     */
    public function setExpiryDate(Carbon $expiryDate): void
    {
        $this->expiryDate = $expiryDate;
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
