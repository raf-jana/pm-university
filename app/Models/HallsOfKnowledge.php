<?php

namespace App\Models;

use Carbon\Carbon;

class HallsOfKnowledge extends BaseModel
{
    protected $table = 'halls_of_knowledge';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            $complaint->published_at = Carbon::now();
        });
    }

    public static function defaultAttributes($overrides = [])
    {
        return array_merge(['id', 'title', 'picture', 'link'], $overrides);
    }
}
