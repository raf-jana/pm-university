<?php

namespace App\Models;

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
     * An article belongs to a post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
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

    public function imagePath(): string
    {
        return $this->picture ? 'images/articles/' . $this->picture : '';
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'picture' => $this->imagePath(),
            'video_url' => $this->videoUrl(),
            'published' => $this->isPublished()
        ]);
    }
}
