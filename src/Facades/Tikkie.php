<?php

namespace Cloudmazing\Tikkie\Facades;

use Illuminate\Support\Facades\Facade;

class Tikkie extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tikkie';
    }
}
