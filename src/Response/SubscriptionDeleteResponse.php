<?php

namespace Cloudmazing\Tikkie\Response;

/**
 * Class SubscriptionDeleteResponse.
 *
 * @category Response
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class SubscriptionDeleteResponse extends BaseResponse
{
    /**
     * A unique identifier for the request.
     *
     * @var string
     */
    protected $traceId;

    /**
     * Get the trace id.
     *
     * @return string
     */
    public function getTaceId(): string
    {
        return $this->traceId;
    }
}
