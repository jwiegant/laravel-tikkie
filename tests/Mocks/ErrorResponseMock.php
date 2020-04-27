<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Illuminate\Support\Facades\Http;

/**
 * Class ErrorResponseMock.
 *
 * @category Tests\Mocks
 * @package Cloudmazing\Tikkie\Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ErrorResponseMock
{
    /**
     * ErrorResponseMock constructor.
     *
     * @param string $code
     * @param string $message
     * @param string $reference
     * @param string $traceId
     * @param int $status
     */
    public function __construct(
        string $code,
        string $message,
        string $reference,
        string $traceId,
        int $status
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/*' => Http::response(
                    [
                        'errors' => [
                            [
                                'code' => $code,
                                'message' => $message,
                                'reference' => $reference,
                                'traceId' => $traceId,
                                'status' => $status
                            ]
                        ]
                    ],
                    $status,
                    ['Headers']
                ),
            ]
        );
    }
}
