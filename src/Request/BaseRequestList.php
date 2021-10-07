<?php

namespace Cloudmazing\Tikkie\Request;

use Carbon\Carbon;

/**
 * Class BaseRequestList.
 *
 * @category Request
 *
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
abstract class BaseRequestList extends BaseRequest
{
    /**
     * Number of the page to be returned. Starts at zero.
     */
    protected int $pageNumber = 0;

    /**
     * Number of items on a page. Range: 1-50.
     */
    protected int $pageSize = 50;

    /**
     * Point in time where to start searching for items. Format:
     * YYYY-MM-DDTHH:mm:ss.SSSZ.
     *
     * @var Carbon|null
     */
    protected ?Carbon $fromDateTime;

    /**
     * Point in time where to stop searching for items. Format:
     * YYYY-MM-DDTHH:mm:ss.SSSZ.
     *
     * @var Carbon|null
     */
    protected ?Carbon $toDateTime;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array Casts array
     */
    protected array $casts = [
        'fromDateTime' => [
            'type' => 'carbon',
            'format' => 'Y-m-d\TH:i:s.000\Z',
            'nullable' => true,
        ],
        'toDateTime' => [
            'type' => 'carbon',
            'format' => 'Y-m-d\TH:i:s.000\Z',
            'nullable' => true,
        ],
    ];

    /**
     * Parameters to include in the payload.
     *
     * @var array Payload array
     */
    protected array $payload = [
        'pageNumber',
        'pageSize',
        'fromDateTime',
        'toDateTime',
    ];

    /**
     * Get the page number.
     *
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * Set the page number.
     *
     * @param  int  $pageNumber
     */
    public function setPageNumber(int $pageNumber): void
    {
        $this->pageNumber = $pageNumber;
    }

    /**
     * Get the page size.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * Set the page size.
     *
     * @param  int  $pageSize
     */
    public function setPageSize(int $pageSize): void
    {
        $this->pageSize = $pageSize;
    }

    /**
     * Get the from datetime.
     *
     * @return Carbon
     */
    public function getFromDateTime(): Carbon
    {
        return $this->fromDateTime;
    }

    /**
     * Set the from datetime.
     *
     * @param  Carbon  $fromDateTime
     */
    public function setFromDateTime(Carbon $fromDateTime): void
    {
        $this->fromDateTime = $fromDateTime;
    }

    /**
     * Get the to datetime.
     *
     * @return Carbon
     */
    public function getToDateTime(): Carbon
    {
        return $this->toDateTime;
    }

    /**
     * Set the to datetime.
     *
     * @param  Carbon  $toDateTime
     */
    public function setToDateTime(Carbon $toDateTime): void
    {
        $this->toDateTime = $toDateTime;
    }

    /** Abstract function to get the action */
    abstract public function getAction();
}
