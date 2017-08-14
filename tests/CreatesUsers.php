<?php

namespace Tests;

use App\Models\User;

trait CreatesUsers
{
    protected function createUser(array $attributes = []): User
    {
        return factory(User::class)->create(array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }
}