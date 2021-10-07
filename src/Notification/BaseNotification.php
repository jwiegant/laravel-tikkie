<?php

namespace Cloudmazing\Tikkie\Notification;

use Cloudmazing\Tikkie\Response\BaseResponse;

/**
 * Class BaseNotification.
 *
 * @category Notification
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
abstract class BaseNotification extends BaseResponse
{
    /**
     * Constants.
     */
    public const NOTIFICATION_TYPE_PAYMENT = 'PAYMENT';
    public const NOTIFICATION_TYPE_REFUND = 'REFUND';
}
