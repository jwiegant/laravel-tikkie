<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\Application;
use Cloudmazing\Tikkie\Request\PaymentItem;
use Cloudmazing\Tikkie\Request\PaymentList;
use Cloudmazing\Tikkie\Request\PaymentRequestCreate;
use Cloudmazing\Tikkie\Request\PaymentRequestItem;
use Cloudmazing\Tikkie\Request\PaymentRequestList;
use Cloudmazing\Tikkie\Request\RefundCreate;
use Cloudmazing\Tikkie\Request\RefundItem;
use Cloudmazing\Tikkie\Request\SubscriptionCreate;
use Cloudmazing\Tikkie\Request\SubscriptionDelete;
use Cloudmazing\Tikkie\Response\ErrorListResponse;
use Exception;
use http\Client\Response;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Http;

/**
 * Class BaseRequest.
 *
 * @category Calls
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
abstract class BaseRequest
{
    /**
     * Constants.
     */
    const HTTPS_API_ABNAMRO_COM = 'https://api.abnamro.com';
    const HTTPS_API_SANDBOX_ABNAMRO_COM = 'https://api-sandbox.abnamro.com';
    const TIKKIE_VERSION_POINT = '/v2/tikkie/';

    /**
     * Action calls.
     */
    const PAYMENT_REQUESTS = 'paymentrequests';
    const SANDBOX_APPS = 'sandboxapps';
    const PAYMENT_REQUESTS_SUBSCRIPTION = 'paymentrequestssubscription';

    /**
     * @var Repository|mixed Api Key
     */
    private $_apiKey;

    /**
     * @var Repository|mixed App Token
     */
    private $_appToken;

    /**
     * @var Repository|mixed Sandbox
     */
    private $_sandbox;

    /**
     * BaseRequest constructor.
     *
     * @param  string|null  $apiKey
     * @param  string|null  $appToken
     * @param  bool  $sandbox
     */
    public function __construct(
        string $apiKey = null,
        string $appToken = null,
        bool $sandbox = false
    ) {
        // If an Api key is supplied then use the supplied parameters
        if (! is_null($apiKey)) {
            $this->_apiKey = $apiKey;
            $this->_appToken = $appToken;
            $this->_sandbox = $sandbox;
        } else {
            // Use the parameters from the config
            $this->_apiKey = config('tikkie.api-key');
            $this->_appToken = config('tikkie.app-token');
            $this->_sandbox = config('tikkie.sandbox');
        }
    }

    /**
     * Get the action based on the request class.
     *
     * @param  Request\BaseRequest  $baseRequest
     *
     * @return mixed
     * @throws Exception
     */
    protected function getAction(Request\BaseRequest $baseRequest)
    {
        // Get the class name of the request
        switch (get_class($baseRequest)) {
            // Application Request
            case Application::class:
                $action = self::SANDBOX_APPS;
                break;

            // Payment Request List or Create
            case PaymentRequestList::class:
            case PaymentRequestCreate::class:
                $action = self::PAYMENT_REQUESTS;
                break;

            // Payment Request Item
            case PaymentRequestItem::class:
                /**
                 * $baseRequest is of the type PaymentRequestItem.
                 *
                 * @var PaymentRequestItem $baseRequest
                 */
                $action = self::PAYMENT_REQUESTS;
                $action .= "/{$baseRequest->getPaymentRequestToken()}";
                break;

            // Payment Item
            case PaymentItem::class:
                /**
                 * $baseRequest is of the type PaymentItem.
                 *
                 * @var PaymentItem $baseRequest
                 */
                $action = self::PAYMENT_REQUESTS;
                $action .= "/{$baseRequest->getPaymentRequestToken()}";
                $action .= "/payments/{$baseRequest->getPaymentToken()}";
                break;

            // Payment List
            case PaymentList::class:
                /**
                 * $baseRequest is of the type PaymentList.
                 *
                 * @var PaymentList $baseRequest
                 */
                $action = self::PAYMENT_REQUESTS;
                $action .= "/{$baseRequest->getPaymentRequestToken()}/payments";
                break;

            // Refund Create
            case RefundCreate::class:
                /**
                 * $baseRequest is of the type RefundCreate.
                 *
                 * @var RefundCreate $baseRequest
                 */
                $action = self::PAYMENT_REQUESTS;
                $action .= "/{$baseRequest->getPaymentRequestToken()}";
                $action .= "/payments/{$baseRequest->getPaymentToken()}";
                $action .= '/refunds';
                break;

            // Refund Item
            case RefundItem::class:
                /**
                 * $baseRequest is of the type RefundItem.
                 *
                 * @var RefundItem $baseRequest
                 */
                $action = self::PAYMENT_REQUESTS;
                $action .= "/{$baseRequest->getPaymentRequestToken()}";
                $action .= "/payments/{$baseRequest->getPaymentToken()}";
                $action .= "/refunds/{$baseRequest->getRefundToken()}";
                break;

            // Subscription Create of Delete
            case SubscriptionCreate::class:
            case SubscriptionDelete::class:
                $action = self::PAYMENT_REQUESTS_SUBSCRIPTION;
                break;

            // Default if the class isn't found, then throw an exception
            default:
                throw new Exception('Unknown class');
        }

        // Return the action
        return $action;
    }

    /**
     * Get the API endpoint.
     *
     * @param  Request\BaseRequest  $baseRequest
     *
     * @return string
     * @throws Exception
     */
    protected function getEndPoint(Request\BaseRequest $baseRequest)
    {
        // Set the end point based on the sandbox variable
        $endPoint = ($this->_sandbox ?
            self::HTTPS_API_SANDBOX_ABNAMRO_COM :
            self::HTTPS_API_ABNAMRO_COM);

        // Return the end point with the action
        return $endPoint.self::TIKKIE_VERSION_POINT.$this->getAction($baseRequest);
    }

    /**
     * Get the header.
     *
     * @return array
     */
    protected function getHeaders()
    {
        // Add the api key to the header
        $headers = [
            'API-Key' => $this->_apiKey,
        ];

        // If we have an app token then add it
        if (! empty($this->_appToken)) {
            $headers['X-App-Token'] = $this->_appToken;
        }

        // Return the headers
        return $headers;
    }

    /**
     * Do a post request.
     *
     * @param  Request\BaseRequest  $baseRequest
     *
     * @return \Illuminate\Http\Client\Response
     * @throws Exception
     */
    protected function postRequest(
        Request\BaseRequest $baseRequest
    ) {
        // Make the request, with headers, post the payload and return as json
        return Http::withHeaders($this->getHeaders())
                   ->contentType('application/json')
                   ->post(
                       $this->getEndPoint($baseRequest),
                       $baseRequest->getPayload()
                   );
    }

    /**
     * Perform a delete request.
     *
     * @param  Request\BaseRequest  $baseRequest
     *
     * @return \Illuminate\Http\Client\Response
     * @throws Exception
     */
    protected function deleteRequest(
        Request\BaseRequest $baseRequest
    ) {
        // Make the request, with headers, post the payload and return as json
        return Http::withHeaders($this->getHeaders())
                   ->contentType('application/json')
                   ->delete(
                       $this->getEndPoint($baseRequest),
                       $baseRequest->getPayload()
                   );
    }

    /**
     * Perform a get request.
     *
     * @param  Request\BaseRequest  $baseRequest
     *
     * @return \Illuminate\Http\Client\Response
     * @throws Exception
     */
    protected function getRequest(
        Request\BaseRequest $baseRequest
    ) {
        return Http::withHeaders($this->getHeaders())
                   ->contentType('application/json')
                   ->get(
                       $this->getEndPoint($baseRequest),
                       $baseRequest->getPayload()
                   );
    }

    /**
     * Check the response of a request.
     *
     * @param  \Illuminate\Http\Client\Response  $response
     * @param  string  $responseClass
     * @param  int  $status
     *
     * @return ErrorListResponse
     * @throws Exception
     */
    protected function checkResponse(
        \Illuminate\Http\Client\Response $response,
        string $responseClass,
        int $status = 200
    ) {
        // If the errors key exists in the response array the create an Error List
        $json = $response->json();

        if (array_key_exists('errors', $json)) {
            // Return the Error List response
            return new ErrorListResponse($json);
        }

        // Status should be in the same 100 range
        if (floor($status / 100) !== floor($response->status() / 100)) {
            // Return the Error List response
            throw new Exception("Incorrect status received. Expected {$status} Received {$response->status()}");
        }

        // Return the response in the given response class
        return new $responseClass($json);
    }
}
