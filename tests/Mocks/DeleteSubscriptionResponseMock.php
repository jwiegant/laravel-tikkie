<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Illuminate\Support\Facades\Http;

/**
 * Class DeleteSubscriptionResponseMock.
 *
 * @category Tests\Mocks
 * @package Cloudmazing\Tikkie\Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class DeleteSubscriptionResponseMock
{
    public function __construct(
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/paymentrequestssubscription' => Http::response(
                    [],
                    204,
                    ['Headers']
                ),
            ]
        );
    }
}
