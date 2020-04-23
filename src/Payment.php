<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\PaymentItem;
use Cloudmazing\Tikkie\Request\PaymentList;
use Cloudmazing\Tikkie\Response\PaymentListResponse;
use Cloudmazing\Tikkie\Response\PaymentResponse;
use Exception;

/**
 * Class Payment
 *
 * @category Calls
 * @package  Cloudmazing\Tikkie
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Payment extends BaseRequest
{
    /**
     * Get the payment payment of a payment request
     *
     * @param  PaymentItem  $paymentItem
     *
     * @return Response\PaymentResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function get(PaymentItem $paymentItem)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentItem
            ),
            PaymentResponse::class
        );
    }

    /**
     * Get a list of payments for a payment request
     *
     * @param  PaymentList  $paymentList
     *
     * @return Response\PaymentListResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function list(PaymentList $paymentList)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentList
            ),
            PaymentListResponse::class
        );
    }
}
