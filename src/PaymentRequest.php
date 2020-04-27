<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\PaymentRequestCreate;
use Cloudmazing\Tikkie\Request\PaymentRequestItem;
use Cloudmazing\Tikkie\Request\PaymentRequestList;
use Cloudmazing\Tikkie\Response\PaymentRequestListResponse;
use Cloudmazing\Tikkie\Response\PaymentRequestResponse;
use Exception;

/**
 * Class PaymentRequest.
 *
 * @category Calls
 * @package Cloudmazing\Tikkie
 * @author  Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequest extends BaseRequest
{
    /**
     * Create a payment request.
     *
     * @param  PaymentRequestCreate  $paymentRequestCreate
     *
     * @return Response\PaymentRequestResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function create(PaymentRequestCreate $paymentRequestCreate)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->postRequest(
                $paymentRequestCreate
            ),
            PaymentRequestResponse::class
        );
    }

    /**
     * List the payment requests.
     *
     * @param  PaymentRequestList  $paymentRequestList
     *
     * @return Response\PaymentRequestListResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function list(PaymentRequestList $paymentRequestList)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentRequestList
            ),
            PaymentRequestListResponse::class
        );
    }

    /**
     * Get a payment request.
     *
     * @param  PaymentRequestItem  $paymentRequestItem
     *
     * @return Response\PaymentRequestResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function get(PaymentRequestItem $paymentRequestItem)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentRequestItem
            ),
            PaymentRequestResponse::class
        );
    }
}
