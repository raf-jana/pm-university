<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Placement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlacementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_placements()
    {
        $stub = create(Placement::class);
        $this->get('/')->assertSee($stub->title);
    }
}
