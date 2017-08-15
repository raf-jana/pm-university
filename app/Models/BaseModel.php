<?php

namespace App\Models;

use Storage;
use App\Traits\Publishable;
use App\Traits\Models\CarbonDates;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Publishable, CarbonDates;

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function imageUrl()
    {
        return $this->picture ? Storage::disk('public')->url($this->picture) : '';
    }
}
