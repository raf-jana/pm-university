<?php

namespace Janaagraha\Sanitizer\Filters;

use Janaagraha\Sanitizer\Contracts\Filter;

class StripTags implements Filter
{

    /**
     *  Strip HTML and PHP tags from the given string.
     *
     * @param  string $value
     * @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? strip_tags($value) : $value;
    }

}
