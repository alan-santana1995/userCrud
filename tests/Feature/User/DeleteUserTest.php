<?php

namespace Tests\Feature\User;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class DeleteUserTest extends UsersTestCase
{
    use WithFaker;

    /**
     * Valida a desativação do usuário.
     */
    public function test_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route(
                'users.update',
                [
                    'user' => $user->id
                ]
            )
        );

        $response->assertOk();

        $expectedData['id'] = $user->id;
        $expectedData['status'] = false;
        $this->assertDatabaseHas(
            'users',
            $expectedData
        );
    }
}
