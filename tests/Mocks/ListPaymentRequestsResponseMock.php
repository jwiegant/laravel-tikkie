<?php


namespace Cloudmazing\Tikkie\Tests\Mocks;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class ListPaymentRequestsResponseMock
 *
 * @category Tests\Mocks
 * @package Cloudmazing\Tikkie\Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ListPaymentRequestsResponseMock
{
    /**
     * ListPaymentRequestsResponseMock constructor.
     *
     * @param int $totalElementCount
     * @param string $paymentRequestToken1
     * @param int $amountInCents1
     * @param string $referenceId1
     * @param string $description1
     * @param string $url1
     * @param Carbon $expiryDate1
     * @param Carbon $createdDateTime1
     * @param string $status1
     * @param int $numberOfPayments1
     * @param int $totalAmountPaidInCents1
     * @param string $paymentRequestToken2
     * @param int $amountInCents2
     * @param string $referenceId2
     * @param string $description2
     * @param string $url2
     * @param Carbon $expiryDate2
     * @param Carbon $createdDateTime2
     * @param string $status2
     * @param int $numberOfPayments2
     * @param int $totalAmountPaidInCents2
     */
    public function __construct(
        int $totalElementCount,
        string $paymentRequestToken1,
        int $amountInCents1,
        string $referenceId1,
        string $description1,
        string $url1,
        Carbon $expiryDate1,
        Carbon $createdDateTime1,
        string $status1,
        int $numberOfPayments1,
        int $totalAmountPaidInCents1,
        string $paymentRequestToken2,
        int $amountInCents2,
        string $referenceId2,
        string $description2,
        string $url2,
        Carbon $expiryDate2,
        Carbon $createdDateTime2,
        string $status2,
        int $numberOfPayments2,
        int $totalAmountPaidInCents2
    )
    {
        Http::fake([
                '*.abnamro.com/v2/tikkie/paymentrequests?*' => Http::response(
                    [
                        "paymentRequests" => [
                            [
                                "paymentRequestToken" => $paymentRequestToken1,
                                "amountInCents" => $amountInCents1,
                                "referenceId" => $referenceId1,
                                "description" => $description1,
                                "url" => $url1,
                                "expiryDate" => $expiryDate1->format('Y-m-d'),
                                "createdDateTime" => $createdDateTime1->format('Y-m-d\TH:i:s.000\Z'),
                                "status" => $status1,
                                "numberOfPayments" => $numberOfPayments1,
                                "totalAmountPaidInCents" => $totalAmountPaidInCents1
                            ],
                            [
                                "paymentRequestToken" => $paymentRequestToken2,
                                "amountInCents" => $amountInCents2,
                                "referenceId" => $referenceId2,
                                "description" => $description2,
                                "url" => $url2,
                                "expiryDate" => $expiryDate2->format('Y-m-d'),
                                "createdDateTime" => $createdDateTime2->format('Y-m-d\TH:i:s.000\Z'),
                                "status" => $status2,
                                "numberOfPayments" => $numberOfPayments2,
                                "totalAmountPaidInCents" => $totalAmountPaidInCents2
                            ],
                        ],
                        "totalElementCount" => $totalElementCount
                    ]
                    , 200, ['Headers']),
            ]
        );
    }
}
