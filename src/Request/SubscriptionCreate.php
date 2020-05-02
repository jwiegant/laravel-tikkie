<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class SubscriptionCreate.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class SubscriptionCreate extends BaseRequest
{
    /**
     * URL where the payment request can be paid.
     *
     * @var string
     */
    protected string $url;

    /**
     * Parameters to include in the payload.
     *
     * @var array
     */
    protected array $payload = [
        'url',
    ];

    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction()
    {
        return self::PAYMENT_REQUESTS_SUBSCRIPTION;
    }

    /**
     * Get the url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the url.
     *
     * @param  string  $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
