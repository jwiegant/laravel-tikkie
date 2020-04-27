<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class CreatePaymentRequestResponseMock.
 *
 * @category Tests\Mocks
 * @package Cloudmazing\Tikkie\Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreatePaymentRequestResponseMock
{
    /**
     * CreatePaymentRequestResponseMock constructor.
     *
     * @param string $paymentRequestToken
     * @param int $amountInCents
     * @param string $referenceId
     * @param string $description
     * @param string $url
     * @param Carbon $expiryDate
     * @param Carbon $createdDateTime
     * @param string $status
     */
    public function __construct(
        string $paymentRequestToken,
        int $amountInCents,
        string $referenceId,
        string $description,
        string $url,
        Carbon $expiryDate,
        Carbon $createdDateTime,
        string $status
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/paymentrequests' => Http::response(
                    [
                        'paymentRequestToken' => $paymentRequestToken,
                        'amountInCents' => $amountInCents,
                        'referenceId' => $referenceId,
                        'description' => $description,
                        'url' => $url,
                        'expiryDate' => $expiryDate->format('Y-m-d'),
                        'createdDateTime' => $createdDateTime->format('Y-m-d\TH:i:s.000\Z'),
                        'status' => $status
                    ],
                    200,
                    ['Headers']
                ),
            ]
        );
    }
}
