<?php

namespace Cloudmazing\Tikkie\Response;

/**
 * Class SubscriptionResponse.
 *
 * @category Response
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class SubscriptionResponse extends BaseResponse
{
    /**
     * Unique identifier for a subscription. This will be sent with the user's
     * payment request notification.
     *
     * @var string
     */
    protected string $subscriptionId;

    /**
     * Get the subscription id.
     *
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }
}
