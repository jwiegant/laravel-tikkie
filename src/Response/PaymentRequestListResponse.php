<?php

namespace Cloudmazing\Tikkie\Response;

use Illuminate\Support\Collection;

/**
 * Class PaymentRequestListResponse
 *
 * @category Response
 * @package  Cloudmazing\Tikkie\Response
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequestListResponse extends BaseResponse
{
    /**
     * Containing all payment requests which match the specified criteria.
     *
     * @var Collection<PaymentRequestResponse>
     */
    protected $paymentRequests;

    /**
     * Total amount of payment requests which match the search parameters provided.
     *
     * @var int
     */
    protected $totalElementCount;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected $casts = [
        'totalElementCount' => ['type' => 'int'],
        'paymentRequests'   => ['type' => 'collection', 'class' => PaymentRequestResponse::class],
    ];

    /**
     * Returns the collection of Payment Requests
     *
     * @return Collection
     */
    public function getPaymentRequests(): Collection
    {
        return $this->paymentRequests;
    }

    /**
     * Returns the total element count
     *
     * @return int
     */
    public function getTotalElementCount(): int
    {
        return $this->totalElementCount;
    }
}
