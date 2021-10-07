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
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Refund extends BaseRequest
{
    /**
     * Get the payment payment of a payment request.
     *
     * @param  string  $paymentRequestToken
     * @param  string  $paymentToken
     * @param  string  $description
     * @param  float  $amount
     * @param  string  $referenceId
     * @return Response\RefundResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function create(
        string $paymentRequestToken,
        string $paymentToken,
        string $description,
        float $amount,
        string $referenceId
    ) {
        $refundCreate = new RefundCreate(
            [
                'paymentRequestToken' => $paymentRequestToken,
                'paymentToken'        => $paymentToken,
                'description'         => $description,
                'amountInCents'       => $amount,
                'referenceId'         => $referenceId,
            ]
        );

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
     * @param  string  $paymentRequestToken
     * @param  string  $paymentToken
     * @param  string  $refundToken
     * @return Response\RefundResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function get(
        string $paymentRequestToken,
        string $paymentToken,
        string $refundToken
    ) {
        $refundItem = new RefundItem(
            [
                'paymentRequestToken' => $paymentRequestToken,
                'paymentToken'        => $paymentToken,
                'refundToken'         => $refundToken,
            ]
        );

        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $refundItem
            ),
            RefundResponse::class
        );
    }
}
