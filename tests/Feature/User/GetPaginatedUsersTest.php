<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class GetPaginatedUsersTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_users_success(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson(route('users.index'));
        $response->assertOk()
            ->assertJsonFragment(
                [
                    'data' => [$user->toArray()]
                ]
            );
    }
}
