<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_articles_of_a_post_based_on_type()
    {
        $stub = factory(Article::class)->create();
        $this->getJson('/posts/' . $stub->post->id . '/articles?type=' . $stub->type)
            ->assertStatus(200);
    }
}
