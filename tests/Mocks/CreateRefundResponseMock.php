<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class CreateRefundResponseMock.
 *
 * @category Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateRefundResponseMock
{
    /**
     * CreateRefundResponseMock constructor.
     *
     * @param  string  $refundToken
     * @param  float  $amount
     * @param  string  $description
     * @param  string  $referenceId
     * @param  Carbon  $createdDateTime
     * @param  string  $status
     */
    public function __construct(
        string $refundToken,
        float $amount,
        string $description,
        string $referenceId,
        Carbon $createdDateTime,
        string $status
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/paymentrequests/*' => Http::response(
                    [
                        'refundToken' => $refundToken,
                        'amountInCents' => $amount * 100,
                        'description' => $description,
                        'referenceId' => $referenceId,
                        'createdDateTime' => $createdDateTime->format('Y-m-d\TH:i:s.000\Z'),
                        'status' => $status,
                    ],
                    200,
                    ['Headers']
                ),
            ]
        );
    }
}
