<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USER = 1;
    const MODERATOR = 2;
    const ADMIN = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();
        return $password !== '' && $password !== null;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
