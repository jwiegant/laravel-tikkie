<?php

namespace Cloudmazing\Tikkie\Response;

use Illuminate\Support\Collection;

/**
 * Class ErrorListResponse.
 *
 * @category Response
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class ErrorListResponse extends BaseResponse
{
    /**
     * The errors in the response.
     *
     * @var Collection<ErrorResponse>
     */
    protected Collection $errors;

    /**
     * This is an error class.
     *
     * @var bool
     */
    protected bool $error = true;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array
     */
    protected array $casts = [
        'errors' => ['type'  => 'collection',
            'class' => ErrorResponse::class, ],
    ];

    /**
     * Returns the errors collection.
     *
     * @return Collection
     */
    public function getErrors(): Collection
    {
        return $this->errors;
    }
}
