<?php

namespace App\Models;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    use Publishable;

    public function imagePath(): string
    {
        return 'images/placements/' . $this->picture;
    }

    public static function defaultAttributes($overrides = [])
    {
        return array_merge(['title', 'summary', 'picture', 'link'], $overrides);
    }
}
