<?php

namespace Tests\Feature\User;

use App\Domain\User\Models\User;

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

    /**
     * Usuários inativos devem ser retornados somente quando a flag é informada
     */
    public function test_get_only_active_users(): void
    {
        $user = User::factory()->create();
        $inactive = User::factory()->inactive()->create();

        $response = $this->getJson(
            route(
                'users.index',
                [
                    'show_inactives' => true
                ]
            )
        );

        $response->assertOk()
            ->assertJsonFragment(
                [
                    'data' => [
                        $inactive->toArray(),
                        $user->toArray()
                    ]
                ]
            )
            ->assertJsonCount(2, 'data');
    }
}
