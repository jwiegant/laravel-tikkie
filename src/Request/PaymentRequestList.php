<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class PaymentRequestList.
 *
 * @category Request
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequestList extends BaseRequestList
{
    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return self::PAYMENT_REQUESTS;
    }
}
