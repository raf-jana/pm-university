<?php

namespace Janaagraha\Sanitizer\Facades;

use Illuminate\Support\Facades\Facade;

class Sanitizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sanitizer';
    }
}