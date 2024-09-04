<?php

namespace Tests\Feature\User;

use App\Models\User;

class GetPaginatedUsersTest extends UsersTestCase
{
    /**
     * Testa uma paginação de usuários padrão
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
