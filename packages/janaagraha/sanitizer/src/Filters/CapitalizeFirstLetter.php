<?php

namespace Janaagraha\Sanitizer\Filters;

use Janaagraha\Sanitizer\Contracts\Filter;

/**
 * Description of CapitalizeFirstLetter
 *
 * @author nagesh.rao
 */
class CapitalizeFirstLetter implements Filter
{

    /**
     *  Make given string's first character uppercase.
     *
     * @param  string $value
     * @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? ucfirst($value) : $value;
    }

}
