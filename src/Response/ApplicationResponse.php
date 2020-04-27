<?php

namespace Cloudmazing\Tikkie\Response;

/**
 * Class ApplicationResponse.
 *
 * @category Response
 * @package  Cloudmazing\Tikkie\Response
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ApplicationResponse extends BaseResponse
{
    /**
     * appToken to use in other requests.
     *
     * @var string
     */
    protected $appToken;

    /**
     * Get the appToken.
     *
     * @return string
     */
    public function getAppToken() : string
    {
        return $this->appToken;
    }
}
