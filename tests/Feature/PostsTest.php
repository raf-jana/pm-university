<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_posts()
    {
        $stub = factory(Post::class)->create();
        $this->get('/')
            ->assertSee($stub->title);
    }

    /** @test */
    public function a_user_can_read_a_single_post()
    {
        $stub = create(Post::class);
        $this->get('/' . $stub->slug)
            ->assertSee($stub->title);
    }
}
