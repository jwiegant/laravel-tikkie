<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\RefundCreate;
use Cloudmazing\Tikkie\Request\RefundItem;
use Cloudmazing\Tikkie\Response\RefundResponse;
use Exception;

/**
 * Class Refund.
 *
 * @category Calls
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Refund extends BaseRequest
{
    /**
     * Get the payment payment of a payment request.
     *
     * @param  RefundCreate  $refundCreate
     *
     * @return Response\RefundResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function create(RefundCreate $refundCreate)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->postRequest(
                $refundCreate
            ),
            RefundResponse::class
        );
    }

    /**
     * Get a list of payments for a payment request.
     *
     * @param  RefundItem  $refundItem
     *
     * @return Response\RefundResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function get(RefundItem $refundItem)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $refundItem
            ),
            RefundResponse::class
        );
    }
}
