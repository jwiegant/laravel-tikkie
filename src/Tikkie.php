<?php

namespace Cloudmazing\Tikkie;

/**
 * Class Tikkie.
 *
 * @category Calls
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Tikkie
{
    /**
     * Api key.
     *
     * @var string
     */
    private $_apiKey;
    /**
     * App token.
     *
     * @var string
     */
    private $_appToken;
    /**
     * Sandbox.
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
     * Set the configuration.
     *
     * @param  string  $apiKey
     * @param  string  $appToken
     * @param  bool  $sandbox
     */
    public function setConfiguration(string $apiKey,
        string $appToken,
        bool $sandbox = false): void
    {
        $this->_apiKey = $apiKey;
        $this->_appToken = $appToken;
        $this->_sandbox = $sandbox;
    }

    /**
     * Get the Application object.
     *
     * @return Application
     */
    public function application(): Application
    {
        return new Application($this->_apiKey, $this->_appToken, $this->_sandbox);
    }

    /**
     * Get the PaymentRequest object.
     *
     * @return PaymentRequest
     */
    public function paymentRequest(): PaymentRequest
    {
        return new PaymentRequest($this->_apiKey, $this->_appToken, $this->_sandbox);
    }

    /**
     * Get the Payment object.
     *
     * @return Payment
     */
    public function payment(): Payment
    {
        return new Payment($this->_apiKey, $this->_appToken, $this->_sandbox);
    }

    /**
     * Get the Refund object.
     *
     * @return Refund
     */
    public function refund(): Refund
    {
        return new Refund($this->_apiKey, $this->_appToken, $this->_sandbox);
    }

    /**
     * Get the Subscription object.
     *
     * @return Subscription
     */
    public function subscription(): Subscription
    {
        return new Subscription($this->_apiKey, $this->_appToken, $this->_sandbox);
    }
}
