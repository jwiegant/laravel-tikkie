<?php

namespace Cloudmazing\Tikkie\Request;

/**
 * Class Application.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class Application extends BaseRequest
{
    /**
     * Get the action.
     *
     * @return string
     */
    public function getAction()
    {
        return self::SANDBOX_APPS;
    }
}
