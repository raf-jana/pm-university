<?php

namespace App\Models;

use Carbon\Carbon;
use App\Filters\ArticleFilters;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends BaseModel
{
    const TOP_TEN = 'top-10';
    const VIDEOS = 'videos';
    const BOOKS = 'books';
    const INTERVIES = 'interviews';
    const TOOLS = 'tools';

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

        static::creating(function ($article) {
            $userId = me() ? me()->id : null;
            $article->user_id = $article->last_user_id = $userId;
            $article->published_at = Carbon::now();
        });
    }

    /**
     * An article belongs to a post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Apply all relevant post filters.
     *
     * @param  Builder $query
     * @param  PostFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ArticleFilters $filters)
    {
        return $filters->apply($query);
    }

    public static function defaultAttributes($overrides = [])
    {
        return array_merge(
            ['id', 'title', 'description', 'source_url', 'picture', 'video_url', 'published_at'],
            $overrides);
    }

    public function videoUrl(): string
    {
        return $this->video_url ? make_youtube_url($this->video_url) : '';
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'picture' => $this->imageUrl(),
            'video_url' => $this->videoUrl(),
            'published' => $this->isPublished(),
            'description' => html_entity_decode($this->description)
        ]);
    }
}
