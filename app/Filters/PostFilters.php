<?php
namespace App\Filters;

class PostFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['type', 'search', 'status', 'start_date', 'end_date'];

    /**
     * Filter the query by a given type.
     *
     * @param  string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($type)
    {
        return $this->builder->where('type', $type);
    }

    /**
     * Filter the query by a given type.
     *
     * @param  string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($status)
    {
        $whereClause = $status == 1 ? 'whereNull' : 'whereNotNull';
        return $this->builder->{$whereClause}('published_at');
    }

    /**
     * Filter the query according to those that are unanswered.
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function search($keyword)
    {
        return $this->builder->where('title', 'like', "%$keyword%");
    }

    protected function start_date($startDate)
    {
        return $this->builder->whereRaw("date(created_at) >= '$startDate'");
    }

    protected function end_date($endDate)
    {
        return $this->builder->whereRaw("date(created_at) <= '$endDate'");
    }
}