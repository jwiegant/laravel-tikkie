<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Request\SubscriptionCreate;
use Cloudmazing\Tikkie\Request\SubscriptionDelete;
use Cloudmazing\Tikkie\Response\SubscriptionDeleteResponse;
use Cloudmazing\Tikkie\Response\SubscriptionResponse;
use Exception;

/**
 * Class Subscription
 *
 * @category Calls
 * @package  Cloudmazing\Tikkie
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Subscription extends BaseRequest
{
    /**
     * Create a subscription
     *
     * @param  SubscriptionCreate  $subscriptionCreate
     *
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function create(SubscriptionCreate $subscriptionCreate)
    {
        // Make the call and check the response
        return $this->checkResponse(
            $this->postRequest(
                $subscriptionCreate
            ),
            SubscriptionResponse::class
        );
    }

    /**
     * Delete a subscription
     *
     * @param  SubscriptionDelete  $subscriptionDelete
     *
     * @return Response\ErrorListResponse
     * @throws Exception
     */
    public function delete(SubscriptionDelete $subscriptionDelete)
    {
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
