<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends BaseModel
{
    use HasSlug;

    const BACHELORE = 'bachelore';
    const MASTER = 'master';
    const SPECIALIZATION = 'specialization';

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            $complaint->user_id = $complaint->last_user_id = auth()->user()->id;
            $complaint->published_at = Carbon::now();
        });
    }

    public function scopeFilterByType($query, $type)
    {
        return $query->latest()->where('type', $type);
    }

    /**
     * A post may have many articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function topTenArticles(): HasMany
    {
        return $this->articles()->where('type', Article::TOP_TEN);
    }

    public function toolsArticles(): HasMany
    {
        return $this->articles()->where('type', Article::TOOLS);
    }

    public function videosArticles(): HasMany
    {
        return $this->articles()->where('type', Article::VIDEOS);
    }

    public function interviewsArticles(): HasMany
    {
        return $this->articles()->where('type', Article::INTERVIES);
    }

    public function booksArticles(): HasMany
    {
        return $this->articles()->where('type', Article::BOOKS);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Fetch a path to the current post.
     *
     * @return string
     */
    public function path(): string
    {
        return $this->slug;
    }

    public static function defaultAttributes($overrides = [])
    {
        return array_merge(['id', 'title', 'type', 'summary', 'slug', 'picture'], $overrides);
    }

    public static function nextRecord($currentRecord)
    {
        $next = self::where('id', '>', $currentRecord->id)
            ->where('type', $currentRecord->type)
            ->orderBy('id', 'asc')
            ->first();
        if (!$next)
            $next = self::where('type', $currentRecord->type)
                ->orderBy('id', 'asc')
                ->first();

        return $next;
    }

    public static function previousRecord($currentRecord)
    {
        $previous = self::where('id', '<', $currentRecord->id)
            ->where('type', $currentRecord->type)
            ->orderBy('id', 'desc')
            ->first();
        if (!$previous)
            $previous = self::where('type', $currentRecord->type)
                ->orderBy('id', 'desc')
                ->first();
        return $previous;
    }

    /**
     * Get the number of favorites for the reply.
     *
     * @return integer
     */
    public function getTopTenCountAttribute()
    {
        return $this->articles()->where('type', Article::TOP_TEN)->count();
    }

}
