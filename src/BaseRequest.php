<?php

namespace Cloudmazing\Tikkie;

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
        bool $sandbox = null
    ) {
        // Set the parameters
        $this->_apiKey = $apiKey ?: config('tikkie.api-key');
        $this->_appToken = $appToken ?: config('tikkie.api-token');
        $this->_sandbox = $sandbox ?: config('tikkie.sandbox');
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
        return $endPoint.self::TIKKIE_VERSION_POINT.$baseRequest->getAction();
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
            throw new Exception(
                "Incorrect status received. Expected {$status} Received {$response->status()}"
            );
        }

        // Return the response in the given response class
        return new $responseClass($json);
    }
}
