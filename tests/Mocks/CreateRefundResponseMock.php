<?php


namespace Cloudmazing\Tikkie\Tests\Mocks;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class CreateRefundResponseMock
 *
 * @category Tests\Mocks
 * @package Cloudmazing\Tikkie\Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateRefundResponseMock
{
    public function __construct(
        string $refundToken,
        int $amountInCents,
        string $description,
        string $referenceId,
        Carbon $createdDateTime,
        string $status
    ) {
        Http::fake([
                '*.abnamro.com/v2/tikkie/paymentrequests/*' => Http::response(
                    [
                        "refundToken" => $refundToken,
                        "amountInCents" => $amountInCents,
                        "description" => $description,
                        "referenceId" => $referenceId,
                        "createdDateTime" => $createdDateTime->format('Y-m-d\TH:i:s.000\Z'),
                        "status" => $status
                    ]
                    , 200, ['Headers']),
            ]
        );
    }
}
