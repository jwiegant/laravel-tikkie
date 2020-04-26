<?php

namespace Cloudmazing\Tikkie\Request;

use Carbon\Carbon;

/**
 * Class BaseRequestList
 *
 * @category Request
 * @package  Cloudmazing\Tikkie\Request
 * @author   Job Wiegant <job@cloudmazing.nl>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 */
class BaseRequestList extends BaseRequest
{
    /**
     * Number of the page to be returned. Starts at zero.
     *
     * @var int
     */
    protected $pageNumber = 0;

    /**
     * Number of items on a page. Range: 1-50
     *
     * @var int
     */
    protected $pageSize = 10;

    /**
     * Point in time where to start searching for items. Format:
     * YYYY-MM-DDTHH:mm:ss.SSSZ
     *
     * @var Carbon
     */
    protected $fromDateTime;

    /**
     * Point in time where to stop searching for items. Format:
     * YYYY-MM-DDTHH:mm:ss.SSSZ.
     *
     * @var Carbon
     */
    protected $toDateTime;

    /**
     * Include refunds in the response.
     *
     * @var bool
     */
    protected $includeRefunds;

    /**
     * Parameters to cast to a specific type.
     *
     * @var array Casts array
     */
    protected $casts = [
        'fromDateTime' => [
            'type'     => 'carbon',
            'format'   => 'Y-m-d\TH:i:s.000\Z',
            'nullable' => true,
        ],
        'toDateTime'   => [
            'type'     => 'carbon',
            'format'   => 'Y-m-d\TH:i:s.000\Z',
            'nullable' => true,
        ],
        'includeRefunds' => [
            'type'      => 'bool'
        ]
    ];

    /**
     * Parameters to include in the payload.
     *
     * @var array Payload array
     */
    protected $payload = [
        'pageNumber',
        'pageSize',
        'fromDateTime',
        'toDateTime',
        'includeRefunds',
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

    /**
     * Set if we want to include refunds.
     *
     * @param  bool  $includeRefunds
     */
    public function setIncludeRefunds(bool $includeRefunds): void
    {
        $this->includeRefunds = $includeRefunds;
    }

    /**
     * Do we want to include refunds?
     *
     * @return bool
     */
    public function isIncludeRefunds(): bool
    {
        return $this->includeRefunds;
    }
}
