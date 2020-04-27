<?php

namespace Cloudmazing\Tikkie\Tests\Mocks;

use Illuminate\Support\Facades\Http;

/**
 * Class ApplicationResponseMock.
 *
 * @category Tests\Mocks
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ApplicationResponseMock
{
    /**
     * ApplicationResponseMock constructor.
     *
     * @param string $appToken
     */
    public function __construct(string $appToken)
    {
        Http::fake(
            [
                '*.abnamro.com/v2/tikkie/sandboxapps' => Http::response(
                    [
                        'appToken' => $appToken,
                    ],
                    200,
                    ['Headers']
                ),
            ]
        );
    }
}
