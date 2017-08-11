<?php

namespace App\Models;

use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Model;

class HallsOfKnowledge extends Model
{
    use Publishable;

    protected $table = 'halls_of_knowledge';

    public function imagePath(): string
    {
        return 'images/hok/' . $this->picture;
    }

    public static function defaultAttributes($overrides = [])
    {
        return array_merge(['title', 'picture', 'link'], $overrides);
    }
}
