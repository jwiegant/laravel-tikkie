<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\PaymentItem;
use Cloudmazing\Tikkie\Request\PaymentList;
use Cloudmazing\Tikkie\Request\PaymentRequestCreate;
use Cloudmazing\Tikkie\Request\PaymentRequestItem;
use Cloudmazing\Tikkie\Request\PaymentRequestList;
use Cloudmazing\Tikkie\Request\RefundCreate;
use Cloudmazing\Tikkie\Request\RefundItem;
use Cloudmazing\Tikkie\Request\SubscriptionCreate;
use Cloudmazing\Tikkie\Request\SubscriptionDelete;
use Cloudmazing\Tikkie\Response\PaymentRequestResponse;
use Exception;
use Illuminate\Support\Carbon;

/**
 * Class Tikkie
 *
 * @category Calls
 * @package  Cloudmazing\Tikkie
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Tikkie
{
    /**
     * Api key
     *
     * @var string
     */
    private $_apiKey;
    /**
     * App token
     *
     * @var string
     */
    private $_appToken;
    /**
     * Sandbox
     *
     * @var bool
     */
    private $_sandbox;

    /**
     * Tikkie constructor.
     */
    public function __construct()
    {
        // Use the parameters from the config
        $this->_apiKey = config('tikkie.api-key');
        $this->_appToken = config('tikkie.app-token');
        $this->_sandbox = config('tikkie.sandbox');
    }

    /**
     * Set the configuration
     *
     * @param string $apiKey
     * @param string $appToken
     * @param bool $sandbox
     */
    public function setConfiguration(string $apiKey, string $appToken, bool $sandbox = false)
    {
        $this->_apiKey = $apiKey;
        $this->_appToken = $appToken;
        $this->_sandbox = $sandbox;
    }

    /**
     * Create a Payment Request
     *
     * @param string $description
     * @param int $amountInCents
     * @param string $referenceId
     * @param $expiryDate
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function createPaymentRequest(string $description, int $amountInCents, string $referenceId, $expiryDate)
    {
        // Set and check the expiryDate
        if (is_string($expiryDate)) {
            $expiryDate = new Carbon($expiryDate);
        } else {
            if (get_class($expiryDate) !== Carbon::class) {
                throw new Exception("Invalid expiryDate provided");
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

        // Create the request object
        $paymentRequest = new PaymentRequest($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         *
         * @var PaymentRequestResponse $paymentRequestResponse
         */
        return $paymentRequest->create($paymentRequestCreate);
    }

    /**
     * Get a list of payment requests
     *
     * @param int $pageNumber
     * @param int $pageSize
     * @param null $fromDateTime
     * @param null $toDateTime
     * @param bool $includeRefunds
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function listPaymentRequests(
        int $pageNumber = 0,
        int $pageSize = 10,
        $fromDateTime = null,
        $toDateTime = null,
        bool $includeRefunds = false
    ) {
        // Create the request input object
        $paymentRequestList = new PaymentRequestList(
            [
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
                'fromDateTime' => $fromDateTime,
                'toDateTime' => $toDateTime,
                'includeRefunds' => $includeRefunds,
            ]
        );

        // Create the request object
        $paymentRequest = new PaymentRequest($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         *
         * @var PaymentRequestResponse $paymentRequestResponse
         */
        return $paymentRequest->list($paymentRequestList);
    }

    /**
     * Get a payment request
     *
     * @param string $paymentRequestToken
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function getPaymentRequest(string $paymentRequestToken)
    {
        // Create the request input object
        $paymentRequestItem = new PaymentRequestItem(
            [
                'paymentRequestToken' => $paymentRequestToken,
            ]
        );

        // Create the request object
        $paymentRequest = new PaymentRequest($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $paymentRequest->get($paymentRequestItem);
    }

    /**
     * Get a list of payments for a payment request token
     *
     * @param string $paymentRequestToken
     * @param int $pageNumber
     * @param int $pageSize
     * @param null $fromDateTime
     * @param null $toDateTime
     * @param bool $includeRefunds
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function listPayments(
        string $paymentRequestToken,
        int $pageNumber = 0,
        int $pageSize = 10,
        $fromDateTime = null,
        $toDateTime = null,
        bool $includeRefunds = false
    ) {
        $paymentList = new PaymentList([
                'paymentRequestToken' => $paymentRequestToken,
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
                'fromDateTime' => $fromDateTime,
                'toDateTime' => $toDateTime,
                'includeRefunds' => $includeRefunds,
            ]
        );

        // Create the payment object
        $payment = new Payment($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $payment->list($paymentList);
    }

    /**
     * Get a payment
     *
     * @param string $paymentRequestToken
     * @param string $paymentToken
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function getPayment(string $paymentRequestToken, string $paymentToken)
    {
        // Create the input object
        $paymentItem = new PaymentItem(
            [
                'paymentRequestToken' => $paymentRequestToken,
                'paymentToken' => $paymentToken
            ]
        );

        // Create the request object
        $payment = new Payment($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $payment->get($paymentItem);
    }

    /**
     * Create a refund
     *
     * @param string $paymentRequestToken
     * @param string $paymentToken
     * @param string $description
     * @param int $amountInCents
     * @param string $referenceId
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function createRefund(
        string $paymentRequestToken,
        string $paymentToken,
        string $description,
        int $amountInCents,
        string $referenceId
    ) {
        $refundCreate = new RefundCreate(
            [
                'paymentRequestToken' => $paymentRequestToken,
                'paymentToken' => $paymentToken,
                'description' => $description,
                'amountInCents' => $amountInCents,
                'referenceId' => $referenceId,
            ]
        );

        // Create the request object
        $refund = new Refund($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $refund->create($refundCreate);
    }

    /**
     * Get a refund
     *
     * @param string $paymentRequestToken
     * @param string $paymentToken
     * @param string $refundToken
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function getRefund(
        string $paymentRequestToken,
        string $paymentToken,
        string $refundToken
    ) {
        $refundItem = new RefundItem([
            'paymentRequestToken' => $paymentRequestToken,
            'paymentToken' => $paymentToken,
            'refundToken' => $refundToken
        ]);

        // Create the request object
        $refund = new Refund($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $refund->get($refundItem);
    }

    /**
     * Create a subscription
     *
     * @param string $url
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function createSubscription(string $url)
    {
        $subscriptionCreate = new SubscriptionCreate(
            [
                'url' => $url
            ]
        );

        // Create the request object
        $subscription = new Subscription($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $subscription->create($subscriptionCreate);
    }

    /**
     * Delete a subscription
     *
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function deleteSubscription()
    {
        $subscriptionDelete = new SubscriptionDelete();

        // Create the request object
        $subscription = new Subscription($this->_apiKey, $this->_appToken, $this->_sandbox);

        /**
         * Make the call
         */
        return $subscription->delete($subscriptionDelete);
    }
}
