<?php

namespace Janaagraha\Sanitizer\Filters;

use Janaagraha\Sanitizer\Contracts\Filter;

class Titleize implements Filter
{

    /**
     *  Convert given string to title case.
     *
     * @param  string $value
     * @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? title_case(strtolower($value)) : $value;
    }

}
