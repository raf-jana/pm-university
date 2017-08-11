<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasSlug, Publishable;

    const BACHELORE = 1;
    const MASTER = 2;
    const SPECIALIZATION = 3;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

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

    public function imagePath(): string
    {
        $picture = $this->picture ?? '01-Analytics.png';
        return 'images/posts/' . $picture;
    }

    public static function defaultAttributes($overrides = [])
    {
        return array_merge(['title', 'summary', 'slug'], $overrides);
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

}
