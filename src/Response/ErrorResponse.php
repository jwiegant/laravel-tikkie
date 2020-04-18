<?php

namespace Cloudmazing\Tikkie\Response;

/**
 * Class ErrorResponse
 *
 * @category Response
 * @package  Cloudmazing\Tikkie\Response
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ErrorResponse extends BaseResponse
{
    /**
     * Constants
     */

    /**
     * amountInCents was not supplied in the request.
     */
    const AMOUNT_IN_CENTS_MISSING = 'AMOUNT_IN_CENTS_MISSING';
    /**
     * The amountInCents is in an invalid format.
     */
    const AMOUNT_IN_CENTS_INVALID = 'AMOUNT_IN_CENTS_INVALID';
    /**
     * The description is too long.
     */
    const DESCRIPTION_MAX_LENGTH_EXCEEDED = 'DESCRIPTION_MAX_LENGTH_EXCEEDED';
    /**
     * description was not supplied in the request.
     */
    const DESCRIPTION_MISSING = 'DESCRIPTION_MISSING';
    /**
     * The expiryDate is in an invalid format.
     */
    const EXPIRY_DATE_INVALID = 'EXPIRY_DATE_INVALID';
    /**
     * The expiryDate is invalid. This date has already passed.
     */
    const EXPIRY_DATE_NOT_ALLOWED = 'EXPIRY_DATE_NOT_ALLOWED';
    /**
     * fromDateTime is in an invalid format.
     */
    const FROM_DATE_TIME_INVALID = 'FROM_DATE_TIME_INVALID';
    /**
     * pageNumber was not supplied in the query.
     */
    const PAGE_NUMBER_MISSING = 'PAGE_NUMBER_MISSING';
    /**
     * pageSize was not supplied in the query.
     */
    const PAGE_SIZE_MISSING = 'PAGE_SIZE_MISSING';
    /**
     * The amountInCents is above the permitted threshold for this organization.
     */
    const PAYMENT_REQUEST_MAX_AMOUNT_EXCEEDED = 'PAYMENT_REQUEST_MAX_AMOUNT_EXCEEDED';
    /**
     * paymentRequestToken is in an invalid format.
     */
    const PAYMENT_REQUEST_TOKEN_INVALID = 'PAYMENT_REQUEST_TOKEN_INVALID';
    /**
     * paymentToken is in an invalid format.
     */
    const PAYMENT_TOKEN_INVALID = 'PAYMENT_TOKEN_INVALID';
    /**
     * The referenceId is in an invalid format.
     */
    const REFERENCE_ID_INVALID = 'REFERENCE_ID_INVALID';
    /**
     * The total refund amount is larger than the payment plus €25.00.
     */
    const REFUND_AMOUNT_IS_TOO_HIGH = 'REFUND_AMOUNT_IS_TOO_HIGH';
    /**
     * refundToken is in an invalid format.
     */
    const REFUND_TOKEN_INVALID = 'REFUND_TOKEN_INVALID';
    /**
     * toDateTime is in an invalid format.
     */
    const TO_DATE_TIME_INVALID = 'TO_DATE_TIME_INVALID';
    /**
     * It is prohibited to use this URL for webhooks.
     */
    const URL_DISALLOWED = 'URL_DISALLOWED';
    /**
     * URL is in an invalid format.
     */
    const URL_INVALID = 'URL_INVALID';
    /**
     * URL was not supplied in the request.
     */
    const URL_MISSING = 'URL_MISSING';
    /**
     * Invalid appToken format.
     */
    const APP_TOKEN_INVALID = 'APP_TOKEN_INVALID';
    /**
     * This appToken has already been used with another API Key.
     */
    const APP_TOKEN_ALREADY_IN_USE = 'APP_TOKEN_ALREADY_IN_USE';
    /**
     * appToken disabled.
     */
    const APP_TOKEN_DISABLED = 'APP_TOKEN_DISABLED';
    /**
     * appToken does not have permission to create or get payment requests.
     */
    const PAYMENT_REQUEST_FORBIDDEN = 'PAYMENT_REQUEST_FORBIDDEN';
    /**
     * appToken does not have permission to create refunds.
     */
    const REFUND_FORBIDDEN = 'REFUND_FORBIDDEN';
    /**
     * This organization does not have bundled payout enabled, which is a
     * prerequisite to create a refund. To enable bundled payout, contact Tikkie
     * Business Support.
     */
    const BUNDLED_PAYOUT_NOT_ENABLED = 'BUNDLED_PAYOUT_NOT_ENABLED';
    /**
     * No payment request was found for the specified paymentRequestToken.
     */
    const PAYMENT_REQUEST_NOT_FOUND = 'PAYMENT_REQUEST_NOT_FOUND';
    /**
     * No payment was found for the specified paymentToken.
     */
    const PAYMENT_NOT_FOUND = 'PAYMENT_NOT_FOUND';
    /**
     * No refund was found for the specified refundToken.
     */
    const REFUND_NOT_FOUND = 'REFUND_NOT_FOUND';
    /**
     * An unknown error occurred.
     */
    const INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';

    /**
     * Error code.
     *
     * @var string
     */
    protected $code;

    /**
     * Error message.
     *
     * @var string
     */
    protected $message;

    /**
     * Reference to AbnAmro regarding the error.
     *
     * @var string
     */
    protected $reference;

    /**
     * The traceId which can be used to debug the error at AbnAmro.
     *
     * @var string
     */
    protected $traceId;

    /**
     * Status code.
     *
     * @var int
     */
    protected $status;

    /**
     * Get the code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get the message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the reference
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Get the traceId
     *
     * @return string
     */
    public function getTraceId(): string
    {
        return $this->traceId;
    }

    /**
     * Get the status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
