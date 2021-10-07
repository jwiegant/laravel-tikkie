<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\PaymentItem;
use Cloudmazing\Tikkie\Request\PaymentList;
use Cloudmazing\Tikkie\Response\PaymentListResponse;
use Cloudmazing\Tikkie\Response\PaymentResponse;
use Exception;

/**
 * Class Payment.
 *
 * @category Calls
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Payment extends BaseRequest
{
    /**
     * Get the payment payment of a payment request.
     *
     * @param  string  $paymentRequestToken
     * @param  string  $paymentToken
     * @return Response\PaymentResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function get(
        string $paymentRequestToken,
        string $paymentToken
    ) {
        // Create the input object
        $paymentItem = new PaymentItem(
            [
                'paymentRequestToken' => $paymentRequestToken,
                'paymentToken'        => $paymentToken,
            ]
        );

        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentItem
            ),
            PaymentResponse::class
        );
    }

    /**
     * Get a list of payments for a payment request.
     *
     * @param  string  $paymentRequestToken
     * @param  bool  $includeRefunds
     * @param  int  $pageNumber
     * @param  int  $pageSize
     * @param  null  $fromDateTime
     * @param  null  $toDateTime
     * @return Response\PaymentListResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function list(
        string $paymentRequestToken,
        bool $includeRefunds = false,
        int $pageNumber = 0,
        int $pageSize = 50,
        $fromDateTime = null,
        $toDateTime = null
    ) {
        $paymentList = new PaymentList(
            [
                'paymentRequestToken' => $paymentRequestToken,
                'includeRefunds'      => $includeRefunds,
                'pageNumber'          => $pageNumber,
                'pageSize'            => $pageSize,
                'fromDateTime'        => $fromDateTime,
                'toDateTime'          => $toDateTime,
            ]
        );

        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentList
            ),
            PaymentListResponse::class
        );
    }
}
