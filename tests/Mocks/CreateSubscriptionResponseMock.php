<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Illuminate\Support\Facades\Http;

/**
 * Class CreateSubscriptionResponseMock.
 *
 * @category Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class CreateSubscriptionResponseMock
{
    public function __construct(
        string $subscriptionId
    ) {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/paymentrequestssubscription' => Http::response(
                    [
                        'subscriptionId' => $subscriptionId,
                    ],
                    201,
                    ['Headers']
                ),
            ]
        );
    }
}
