<?php

namespace Cloudmazing\Tikkie\Response;

/**
 * Class ErrorResponse.
 *
 * @category Response
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ErrorResponse extends BaseResponse
{
    /**
     * Constants.
     */

    /**
     * The amountInCents is in an invalid format.
     */
    public const AMOUNT_IN_CENTS_INVALID = 'AMOUNT_IN_CENTS_INVALID';

    /**
     * amountInCents was not supplied in the request.
     */
    /**
     * The description is too long.
     */
    public const DESCRIPTION_MAX_LENGTH_EXCEEDED = 'DESCRIPTION_MAX_LENGTH_EXCEEDED';
    /**
     * description was not supplied in the request.
     */
    public const DESCRIPTION_MISSING = 'DESCRIPTION_MISSING';
    /**
     * The expiryDate is in an invalid format.
     */
    public const EXPIRY_DATE_INVALID = 'EXPIRY_DATE_INVALID';
    /**
     * The expiryDate is invalid. This date has already passed.
     */
    public const EXPIRY_DATE_NOT_ALLOWED = 'EXPIRY_DATE_NOT_ALLOWED';
    /**
     * fromDateTime is in an invalid format.
     */
    public const FROM_DATE_TIME_INVALID = 'FROM_DATE_TIME_INVALID';
    /**
     * pageNumber was not supplied in the query.
     */
    public const PAGE_NUMBER_MISSING = 'PAGE_NUMBER_MISSING';
    /**
     * The amountInCents is above the permitted threshold for this organization.
     */
    public const PAYMENT_REQUEST_MAX_AMOUNT_EXCEEDED = 'PAYMENT_REQUEST_MAX_AMOUNT_EXCEEDED';
    /**
     * paymentRequestToken is in an invalid format.
     */
    public const PAYMENT_REQUEST_TOKEN_INVALID = 'PAYMENT_REQUEST_TOKEN_INVALID';
    /**
     * paymentToken is in an invalid format.
     */
    public const PAYMENT_TOKEN_INVALID = 'PAYMENT_TOKEN_INVALID';
    /**
     * The referenceId is in an invalid format.
     */
    public const REFERENCE_ID_INVALID = 'REFERENCE_ID_INVALID';
    /**
     * The total refund amount is larger than the payment plus €25.00.
     */
    public const REFUND_AMOUNT_IS_TOO_HIGH = 'REFUND_AMOUNT_IS_TOO_HIGH';
    /**
     * refundToken is in an invalid format.
     */
    public const REFUND_TOKEN_INVALID = 'REFUND_TOKEN_INVALID';
    /**
     * toDateTime is in an invalid format.
     */
    public const TO_DATE_TIME_INVALID = 'TO_DATE_TIME_INVALID';
    /**
     * It is prohibited to use this URL for webhooks.
     */
    public const URL_DISALLOWED = 'URL_DISALLOWED';
    /**
     * URL is in an invalid format.
     */
    public const URL_INVALID = 'URL_INVALID';
    /**
     * URL was not supplied in the request.
     */
    public const URL_MISSING = 'URL_MISSING';
    /**
     * appToken disabled.
     */
    public const APP_TOKEN_DISABLED = 'APP_TOKEN_DISABLED';
    /**
     * appToken does not have permission to create or get payment requests.
     */
    public const PAYMENT_REQUEST_FORBIDDEN = 'PAYMENT_REQUEST_FORBIDDEN';
    /**
     * appToken does not have permission to create refunds.
     */
    public const REFUND_FORBIDDEN = 'REFUND_FORBIDDEN';
    /**
     * No payment request was found for the specified paymentRequestToken.
     */
    public const PAYMENT_REQUEST_NOT_FOUND = 'PAYMENT_REQUEST_NOT_FOUND';
    /**
     * No payment was found for the specified paymentToken.
     */
    public const PAYMENT_NOT_FOUND = 'PAYMENT_NOT_FOUND';
    /**
     * An unknown error occurred.
     */
    public const INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    /**
     * This is an error class.
     *
     * @var bool
     */
    protected bool $error = true;
    /**
     * Error code.
     *
     * @var string
     */
    protected string $code;

    /**
     * Error message.
     *
     * @var string
     */
    protected string $message;

    /**
     * Reference to ABNAMRO regarding the error.
     *
     * @var string
     */
    protected string $reference;

    /**
     * The traceId which can be used to debug the error at ABNAMRO.
     *
     * @var string
     */
    protected string $traceId;

    /**
     * Status code.
     *
     * @var int
     */
    protected int $status;

    /**
     * Get the code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get the message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the reference.
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Get the traceId.
     *
     * @return string
     */
    public function getTraceId(): string
    {
        return $this->traceId;
    }

    /**
     * Get the status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
