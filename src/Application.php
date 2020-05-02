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
    public function create()
    {
        // Create the application request
        $applicationRequest = new \Cloudmazing\Tikkie\Request\Application();

        return $this->checkResponse(
            $this->postRequest(
                $applicationRequest
            ),
            ApplicationResponse::class
        );
    }
}
