<?php

namespace Janaagraha\Sanitizer\Filters;

use Janaagraha\Sanitizer\Contracts\Filter;

class EscapeHTML implements Filter
{

    /**
     *  Remove HTML tags and encode special characters from the given string.
     *
     * @param  string $value
     * @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? e($value) : $value;
    }

}
