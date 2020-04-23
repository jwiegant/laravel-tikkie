<?php

namespace Cloudmazing\Tikkie;

use Cloudmazing\Tikkie\Response\ApplicationResponse;
use Exception;

/**
 * Class Application.
 *
 * @category Calls
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Application extends BaseRequest
{
    /**
     * Create a sandbox Application.
     *
     * @param Request\Application $application
     * @return Response\ApplicationResponse|Response\ErrorListResponse
     * @throws Exception
     */
    public function create(Request\Application $application)
    {
        return $this->checkResponse(
            $this->postRequest(
                $application
            ),
            ApplicationResponse::class
        );
    }
}
