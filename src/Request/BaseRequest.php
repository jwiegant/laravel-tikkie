<?php

namespace Cloudmazing\Tikkie\Request;

use Carbon\Carbon;
use Cloudmazing\Tikkie\Response\ErrorResponse;
use Exception;

/**
 * Class BaseRequest.
 *
 * @category Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
abstract class BaseRequest
{
    /**
     * Constants.
     */
    public const TYPE = 'type';
    public const FORMAT = 'format';
    public const NULLABLE = 'nullable';

    /**
     * Action Constants.
     */
    public const PAYMENT_REQUESTS = 'paymentrequests';
    public const SANDBOX_APPS = 'sandboxapps';
    public const PAYMENT_REQUESTS_SUBSCRIPTION = 'paymentrequestssubscription';

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected array $casts = [];

    /**
     * Parameters to include in the payload.
     *
     * @var array
     */
    protected array $payload = [];

    /**
     * BaseRequest constructor.
     *
     * @param  array|null  $parameters
     *
     * @throws Exception
     */
    public function __construct(array $parameters = null)
    {
        // If the have parameters then parse them
        if (! empty($parameters)) {
            $this->parseParameters($parameters);
        }
    }

    /**
     * Parse the parameters.
     *
     * @param  array  $parameters
     *
     * @throws Exception
     */
    protected function parseParameters(array $parameters): void
    {
        // Get the properties of the current class
        $classProperties = get_class_vars(static::class);

        // Traverse the parameters
        foreach ($parameters as $key => $parameter) {
            // Check if the parameter is found in the class
            if (array_key_exists($key, $classProperties)) {
                // Check if the parameter has ben set in the casts array
                if (in_array($key, $this->casts, true)) {
                    switch ($this->casts) {
                        // Cast to a Carbon date
                        case 'carbon':
                            $parameter = new Carbon($parameter);
                            break;
                        // Cast to an errorResponse
                        case 'error':
                            $parameter = new ErrorResponse($parameter);
                            break;
                    }
                }

                // Set the parameter in the class
                $this->$key = $parameter;
            }
        }
    }

    /**
     * Get the payload for the request.
     *
     * @return array
     * @throws Exception
     */
    public function getPayload(): array
    {
        // Initialize the payload
        $payload = [];

        // Traverse the payload items
        foreach ($this->payload as $item) {
            // Get the value
            $value = ($this->$item ?? null);

            // IF the value is null, then continue to the next parameter
            if ($value === null) {
                continue;
            }

            // Check the casts
            if (array_key_exists($item, $this->casts)) {
                // Check the items
                $castItem = $this->casts[$item];

                switch ($castItem[self::TYPE]) {
                    // Item is a Carbon item
                    case 'carbon':
                        // Get the format
                        $format = $castItem[self::FORMAT];

                        // Get the item
                        /** @var Carbon $carbonItem */
                        $carbonItem = ($this->$item);

                        $value = $carbonItem;
                        if ($value !== null) {
                            // Format the date
                            $value = $carbonItem->format($format);
                        }
                        break;

                    // Item is a boolean
                    case 'bool':
                        // Make a string value true of false based on the value
                        $value = ($value ? 'true' : 'false');
                        break;
                }
            }

            // Set the value
            if ($value !== null) {
                $payload[$item] = $value;
            }
        }

        // Return the payload
        return $payload;
    }

    /** Abstract function to get the action */
    abstract public function getAction();
}
