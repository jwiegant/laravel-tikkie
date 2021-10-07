<?php

namespace Cloudmazing\Tikkie;

use Carbon\Carbon;
use Cloudmazing\Tikkie\Request\PaymentRequestCreate;
use Cloudmazing\Tikkie\Request\PaymentRequestItem;
use Cloudmazing\Tikkie\Request\PaymentRequestList;
use Cloudmazing\Tikkie\Response\PaymentRequestListResponse;
use Cloudmazing\Tikkie\Response\PaymentRequestResponse;
use Exception;
use RuntimeException;

/**
 * Class PaymentRequest.
 *
 * @category Calls
 *
 * @author  Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class PaymentRequest extends BaseRequest
{
    /**
     * Create a payment request.
     *
     * @param  string  $description
     * @param  string  $referenceId
     * @param  null  $expiryDate
     * @param  float|null  $amount
     * @return Response\PaymentRequestResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function create(string $description,
        string $referenceId,
        $expiryDate = null,
        float $amount = null)
    {
        // Set and check the expiryDate
        if ($expiryDate === null) {
            // Default expiry date of 14 days
            $expiryDate = Carbon::now()
                                ->addDays(14);
        } elseif (is_string($expiryDate)) {
            $expiryDate = new Carbon($expiryDate);
        } elseif (get_class($expiryDate) !== Carbon::class) {
            throw new RuntimeException('Invalid expiryDate provided');
        }

        // Create the request input object
        $paymentRequestCreate = new PaymentRequestCreate(
            [
                'description' => $description,
                'expiryDate'  => $expiryDate,
                'referenceId' => $referenceId,
            ]
        );

        // Set the amount if it's specified
        if ($amount !== null) {
            $paymentRequestCreate->setAmountInCents(round($amount * 100));
        }

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
     * @param  int  $pageNumber
     * @param  int  $pageSize
     * @param  null  $fromDateTime
     * @param  null  $toDateTime
     * @return Response\PaymentRequestListResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function list(
        int $pageNumber = 0,
        int $pageSize = 50,
        $fromDateTime = null,
        $toDateTime = null
    ) {
        // Create the request input object
        $paymentRequestList = new PaymentRequestList(
            [
                'pageNumber'   => $pageNumber,
                'pageSize'     => $pageSize,
                'fromDateTime' => $fromDateTime,
                'toDateTime'   => $toDateTime,
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
     * @return Response\PaymentRequestResponse|Response\ErrorListResponse
     *
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
