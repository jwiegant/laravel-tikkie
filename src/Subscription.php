<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\SubscriptionCreate;
use Cloudmazing\Tikkie\Request\SubscriptionDelete;
use Cloudmazing\Tikkie\Response\SubscriptionDeleteResponse;
use Cloudmazing\Tikkie\Response\SubscriptionResponse;
use Exception;

/**
 * Class Subscription.
 *
 * @category Calls
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Subscription extends BaseRequest
{
    /**
     * Create a subscription.
     *
     * @param  string  $url
     * @return Response\SubscriptionResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function create(string $url)
    {
        $subscriptionCreate = new SubscriptionCreate(
            [
                'url' => $url,
            ]
        );

        // Make the call and check the response
        return $this->checkResponse(
            $this->postRequest(
                $subscriptionCreate
            ),
            SubscriptionResponse::class
        );
    }

    /**
     * Delete a subscription.
     *
     * @return Response\SubscriptionDeleteResponse|Response\ErrorListResponse
     *
     * @throws Exception
     */
    public function delete()
    {
        // Create a subscription delete request
        $subscriptionDelete = new SubscriptionDelete();

        // Make the call and check the response
        return $this->checkResponse(
            $this->deleteRequest(
                $subscriptionDelete
            ),
            SubscriptionDeleteResponse::class,
            204
        );
    }
}
