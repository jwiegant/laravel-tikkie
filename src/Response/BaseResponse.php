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
            if (key_exists(
                $key,
                $classProperties
            )
            ) {
                // Check if the parameter key exist in the cast variable
                if (key_exists(
                    $key,
                    $this->casts
                )
                ) {
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
                            // Cast to a base 10 integer
                            $parameter = intval(
                                $parameter,
                                10
                            );
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

                // Set the parameter in the class
                $this->$key = $parameter;
            }
        }
    }
}
