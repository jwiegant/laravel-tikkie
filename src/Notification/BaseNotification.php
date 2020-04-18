<?php

namespace Cloudmazing\Tikkie\Notification;

use Cloudmazing\Tikkie\Response\BaseResponse;

/**
 * Class BaseNotification
 *
 *
 * @category Notification
 * @package  Cloudmazing\Tikkie
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
abstract class BaseNotification extends BaseResponse
{
    /**
     * Constants
     */
    const NOTIFICATION_TYPE_PAYMENT = 'PAYMENT';
    const NOTIFICATION_TYPE_REFUND = 'REFUND';
}
