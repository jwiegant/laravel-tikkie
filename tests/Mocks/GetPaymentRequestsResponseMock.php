<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class GetPaymentRequestsResponseMock.
 *
 * @category Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class GetPaymentRequestsResponseMock
{
    /**
     * GetPaymentRequestsResponseMock constructor.
     *
     * @param  string  $paymentRequestToken
     * @param  float  $amount
     * @param  string  $referenceId
     * @param  string  $description
     * @param  string  $url
     * @param  Carbon  $expiryDate
     * @param  Carbon  $createdDateTime
     * @param  string  $status
     * @param  int  $numberOfPayments
     * @param  int  $totalAmountPaidInCents
     */
    public function __construct(
        string $paymentRequestToken,
        float $amount,
        string $referenceId,
        string $description,
        string $url,
        Carbon $expiryDate,
        Carbon $createdDateTime,
        string $status,
        int $numberOfPayments,
        int $totalAmountPaidInCents
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/paymentrequests/*' => Http::response(
                    [
                        'paymentRequestToken' => $paymentRequestToken,
                        'amountInCents' => $amount * 100,
                        'referenceId' => $referenceId,
                        'description' => $description,
                        'url' => $url,
                        'expiryDate' => $expiryDate->format('Y-m-d'),
                        'createdDateTime' => $createdDateTime->format('Y-m-d\TH:i:s.000\Z'),
                        'status' => $status,
                        'numberOfPayments' => $numberOfPayments,
                        'totalAmountPaidInCents' => $totalAmountPaidInCents,
                    ],
                    200,
                    ['Headers']
                ),
            ]
        );
    }
}
