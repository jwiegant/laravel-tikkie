<?php

namespace Cloudmazing\Tikkie;

use Carbon\Carbon;
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
 * @author  Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequest extends BaseRequest
{
    /**
     * Create a payment request.
     *
     * @param  string  $description
     * @param  int  $amountInCents
     * @param  string  $referenceId
     * @param $expiryDate
     *
     * @return Response\PaymentRequestResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function create(string $description, int $amountInCents, string $referenceId, $expiryDate)
    {
        // Set and check the expiryDate
        if (is_string($expiryDate)) {
            $expiryDate = new Carbon($expiryDate);
        } else {
            if (get_class($expiryDate) !== Carbon::class) {
                throw new Exception('Invalid expiryDate provided');
            }
        }

        // Create the request input object
        $paymentRequestCreate = new PaymentRequestCreate(
            [
                'description' => $description,
                'amountInCents' => $amountInCents,
                'expiryDate' => $expiryDate,
                'referenceId' => $referenceId,
            ]
        );

        // Make the call and check the response
        return $this->checkResponse(
            $this->postRequest(
                $paymentRequestCreate
            ),
            PaymentRequestResponse::class
        );
    }

    /**
     * Get a list of payment requests.
     *
     * @param  bool  $includeRefunds
     * @param  int  $pageNumber
     * @param  int  $pageSize
     * @param  null  $fromDateTime
     * @param  null  $toDateTime
     *
     * @return Response\PaymentRequestListResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function list(
        bool $includeRefunds = false,
        int $pageNumber = 0,
        int $pageSize = 10,
        $fromDateTime = null,
        $toDateTime = null
    ) {
        // Create the request input object
        $paymentRequestList = new PaymentRequestList(
            [
                'includeRefunds' => $includeRefunds,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
                'fromDateTime' => $fromDateTime,
                'toDateTime' => $toDateTime,
            ]
        );

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
     * @param  string  $paymentRequestToken
     *
     * @return Response\PaymentRequestResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function get(string $paymentRequestToken)
    {
        // Create the request input object
        $paymentRequestItem = new PaymentRequestItem(
            [
                'paymentRequestToken' => $paymentRequestToken,
            ]
        );

        // Make the call and check the response
        return $this->checkResponse(
            $this->getRequest(
                $paymentRequestItem
            ),
            PaymentRequestResponse::class
        );
    }
}
