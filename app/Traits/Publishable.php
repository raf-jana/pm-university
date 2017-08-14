<?php

namespace App\Traits;

trait Publishable
{

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function publish()
    {
        $this->update(['published_at' => $this->freshTimestamp()]);
    }

    public function unpublish()
    {
        $this->update(['published_at' => null]);
    }

    public function isPublished()
    {
        return $this->published_at !== null;
    }
}