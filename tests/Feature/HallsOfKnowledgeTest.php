<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\HallsOfKnowledge;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HallsOfKnowledgeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_halls_of_knowledge()
    {
        $stub = create(HallsOfKnowledge::class);
        $this->get('/')->assertSee($stub->title);
    }
}
