<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class SubscriptionDelete.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class SubscriptionDelete extends BaseRequest
{
    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return self::PAYMENT_REQUESTS_SUBSCRIPTION;
    }
}
