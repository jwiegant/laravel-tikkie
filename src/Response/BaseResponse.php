<?php

namespace Cloudmazing\Tikkie\Response;

use Carbon\Carbon;
use Exception;

/**
 * Class BaseResponse.
 *
 * @category Response
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
abstract class BaseResponse
{
    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Is this an error class.
     *
     * @var bool
     */
    protected $error = false;

    /**
     * Base constructor.
     *
     * @param  array  $parameters
     *
     * @throws Exception
     */
    public function __construct($parameters)
    {
        $this->parseParameters($parameters);
    }

    /**
     * Parse the given parameters to object properties.
     *
     * @param  array  $parameters
     *
     * @throws Exception
     */
    protected function parseParameters(array $parameters)
    {
        // Get the variables of the current class
        $classProperties = get_class_vars(get_called_class());

        // Traverse the given parameters
        foreach ($parameters as $key => $parameter) {
            // Check if the parameter key exist in the class properties
            if (array_key_exists($key, $classProperties)) {
                // Set the parameter in the class
                $this->$key = $this->parseParameter($key, $parameter);
            }
        }
    }

    /**
     * @param $key
     * @param $parameter
     *
     * @return Carbon|ErrorResponse|\Illuminate\Support\Collection|int
     * @throws Exception
     */
    protected function parseParameter(
        $key,
        $parameter
    ) {
        // Check if the parameter key exist in the cast variable
        if (array_key_exists($key, $this->casts)) {
            // Get the cast item
            $castItem = $this->casts[$key];

            // Get the type
            $type = $castItem['type'];

            // Cast based on the type
            switch ($type) {
                case 'carbon':
                    // Cast to a Carbon object
                    $parameter = new Carbon($parameter);
                    break;
                case 'int':
                    // Cast to an integer
                    $parameter = (int) $parameter;
                    break;
                case 'collection':
                    // Cast to a collection
                    $class = $castItem['class'];
                    $parameter = collect($parameter)->mapInto($class);
                    break;
                case 'error':
                    // Cast to an error response
                    $parameter = new ErrorResponse($parameter);
                    break;
            }
        }

        // Return the parameter
        return $parameter;
    }

    /**
     * Is this an error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * Return the response as an Array.
     *
     * @return array
     */
    public function asArray(): array
    {
        // Get the variables of the current class
        $classProperties = get_class_vars(get_called_class());

        // Initialize the result
        $result = [];

        // Traverse the class properties
        foreach ($classProperties as  $classProperty => $value) {
            if ($classProperty !== 'casts') {
                // Add them to the result
                $result[$classProperty] = $this->$classProperty;
            }
        }

        // Return the result
        return $result;
    }
}
