<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Carbon\Carbon;
use Cloudmazing\Tikkie\Tests\Helpers\Helper;
use Illuminate\Support\Facades\Http;

/**
 * Class GetPaymentResponseMock.
 *
 * @category Tests\Mocks
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class GetPaymentResponseMock
{
    /**
     * GetPaymentResponseMock constructor.
     *
     * @param  string  $paymentToken
     * @param  int  $tikkieId
     * @param  string  $counterPartyName
     * @param  string  $counterPartyAccountNumber
     * @param  float  $amount
     * @param  string  $description
     * @param  Carbon  $createdDateTime
     * @param  string  $refundToken
     * @param  float  $refundAmount
     * @param  string  $refundDescription
     * @param  string  $refundReferenceId
     * @param  Carbon  $refundCreatedDateTime
     * @param  string  $refundStatus
     */
    public function __construct(
        string $paymentToken,
        int $tikkieId,
        string $counterPartyName,
        string $counterPartyAccountNumber,
        float $amount,
        string $description,
        Carbon $createdDateTime,
        string $refundToken,
        float $refundAmount,
        string $refundDescription,
        string $refundReferenceId,
        Carbon $refundCreatedDateTime,
        string $refundStatus
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/paymentrequests/*' => Http::response(
                    [
                        'paymentToken' => $paymentToken,
                        'tikkieId' => $tikkieId,
                        'counterPartyName' => $counterPartyName,
                        'counterPartyAccountNumber' => $counterPartyAccountNumber,
                        'amountInCents' => (new Helper())->getAmount($amount),
                        'description' => $description,
                        'createdDateTime' => $createdDateTime->format('Y-m-d\TH:i:s.000\Z'),
                        'refunds' => [
                            [
                                'refundToken' => $refundToken,
                                'amountInCents' => (new Helper())->getAmount($refundAmount),
                                'description' => $refundDescription,
                                'referenceId' => $refundReferenceId,
                                'createdDateTime' => $refundCreatedDateTime->format('Y-m-d\TH:i:s.000\Z'),
                                'status' => $refundStatus,
                            ],
                        ],
                    ],
                    200,
                    ['Headers']
                ),
            ]
        );
    }
}
