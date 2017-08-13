<?php

namespace Janaagraha\Sanitizer;

use Closure;
use InvalidArgumentException;

class Sanitizer
{
    /*
      |-------------------------------------------------------------------------
      | Sanitizer Service
      |-------------------------------------------------------------------------
      |
      | Data sanitizer and form request input sanitation
      |
     */

    /**
     *  Data to sanitize
     * @var array
     */
    protected $data;

    /**
     *  Filters to apply
     * @var array
     */
    protected $rules;

    /**
     *  Available filters as $name => $classPath
     * @var array
     */
    protected $filters = [
        'trim' => \Janaagraha\Sanitizer\Filters\Trim::class,
        'titleize' => \Janaagraha\Sanitizer\Filters\Titleize::class,
        'capitalize_first_letter' => \Janaagraha\Sanitizer\Filters\CapitalizeFirstLetter::class,
        'cast' => \Janaagraha\Sanitizer\Filters\Cast::class,
        'escape_html' => \Janaagraha\Sanitizer\Filters\EscapeHTML::class,
        'strip_tags' => \Janaagraha\Sanitizer\Filters\StripTags::class,
        'format_date' => \Janaagraha\Sanitizer\Filters\FormatDate::class,
        'lowercase' => \Janaagraha\Sanitizer\Filters\Lowercase::class,
        'uppercase' => \Janaagraha\Sanitizer\Filters\Uppercase::class
    ];

    /**
     *  Create a new sanitizer instance.
     *
     * @param  array $data
     * @param  array $rules Rules to be applied to each data attribute
     * @param  array $filters Available filters for this sanitizer
     * @return Sanitizer
     */
    public function __construct(array $data, array $rules, array $customFilters = [])
    {
        $this->data = $data;
        $this->rules = $this->parseRulesArray($rules);
        $this->filters = array_merge($this->filters, $customFilters);
    }

    /**
     *  Parse a rules array.
     *
     * @param  array $rules
     * @return array
     */
    protected function parseRulesArray(array $rules)
    {
        $parsedRules = [];
        foreach ($rules as $attribute => $attributeRules) {
            $attributeRulesArray = explode('|', $attributeRules);
            foreach ($attributeRulesArray as $attributeRule) {
                $parsedRule = $this->parseRuleString($attributeRule);
                if ($parsedRule) {
                    $parsedRules[$attribute][] = $parsedRule;
                }
            }
        }
        return $parsedRules;
    }

    /**
     *  Sanitize the given data
     * @return array
     */
    public function sanitize()
    {
        $sanitized = [];
        foreach ($this->data as $name => $value) {
            $sanitized[$name] = $this->sanitizeAttribute($name, $value);
        }
        return $sanitized;
    }

    /**
     *  Sanitize the given attribute
     *
     * @param  string $attribute Attribute name
     * @param  mixed $value Attribute value
     * @return mixed   Sanitized value
     */
    protected function sanitizeAttribute($attribute, $value)
    {
        if (isset($this->rules[$attribute])) {
            foreach ($this->rules[$attribute] as $rule) {
                $value = $this->applyFilter($rule['name'], $value, $rule['options']);
            }
        }
        return $value;
    }

    /**
     *  Apply the given filter by its name
     * @param  $name
     * @return Filter
     */
    protected function applyFilter($name, $value, $options = [])
    {
        // If the filter does not exist, throw an Exception:
        if (!isset($this->filters[$name])) {
            throw new InvalidArgumentException(__('errors.filter_not_found', ['name' => $name]));
        }
        $filter = $this->filters[$name];
        if ($filter instanceof Closure) {
            return call_user_func_array($filter, [$value, $options]);
        } else {
            $filter = new $filter;
            return $filter->apply($value, $options);
        }
    }

    /**
     *  Parse a rule string formatted as filterName:option1, option2 into an array formatted as [name => filterName, options => [option1, option2]]
     *
     * @param  string $rule Formatted as 'filterName:option1, option2' or just 'filterName'
     * @return array           Formatted as [name => filterName, options => [option1, option2]]. Empty array if no filter name was found.
     */
    protected function parseRuleString($rule)
    {
        if (strpos($rule, ':') !== false) {
            list($name, $options) = explode(':', $rule, 2);
            $options = array_map('trim', explode(',', $options));
        } else {
            $name = $rule;
            $options = [];
        }
        if (!$name) {
            return [];
        }
        return compact('name', 'options');
    }

}