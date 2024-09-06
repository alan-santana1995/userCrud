<?php

namespace Tests\Feature\User;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeactivateUserTest extends UsersTestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * Testa desativar um usuário.
     */
    public function test_deactivate_active_users(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route(
                'users.destroy',
                [
                    'user' => $user->id
                ]
            )
        );

        $response->assertOk();

        $this->assertDatabaseHas(
            'users',
            [
                'id' => $user->id,
                'status' => false
            ]
        );
    }
}
