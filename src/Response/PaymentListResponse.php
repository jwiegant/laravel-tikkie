<?php

namespace Cloudmazing\Tikkie\Response;

use Illuminate\Support\Collection;

/**
 * Class PaymentListResponse.
 *
 * @category Response
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentListResponse extends BaseResponse
{
    /**
     * All payments which match the specified criteria.
     *
     * @var Collection<PaymentResponse>
     */
    protected Collection $payments;

    /**
     *Total amount of payments which match the search parameters provided.
     *
     * @var int
     */
    protected int $totalElementCount;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected array $casts = [
        'totalElementCount' => ['type' => 'int'],
        'payments'          => ['type'  => 'collection',
            'class' => PaymentResponse::class, ],
    ];

    /**
     * Returns the collection of payments.
     *
     * @return Collection
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * Returns the total element count.
     *
     * @return int
     */
    public function getTotalElementCount(): int
    {
        return $this->totalElementCount;
    }
}
