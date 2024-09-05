<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class UpdateUsersTest extends UsersTestCase
{
    use WithFaker;

    /**
     * Testa a atualização de um usuário já cadastrado.
     * CPF obtido do site: https://www.4devs.com.br/gerador_de_cpf
     */
    public function test_update_user(): void
    {
        $user = User::factory()->create();
        $expectedData = [
            'name' => $this->faker()->name(),
        ];

        $response = $this->patchJson(
            route(
                'users.update',
                [
                    'user' => $user->id
                ]
            ),
            $expectedData
        );

        $response->assertOk();

        $expectedData['id'] = $user->id;
        $this->assertDatabaseHas(
            'users',
            $expectedData
        );
    }

    public function test_disable_user()
    {
        $user = User::factory()->create();
        $expectedData = [
            'status' => false,
        ];

        $response = $this->patchJson(
            route(
                'users.update',
                [
                    'user' => $user->id
                ]
            ),
            $expectedData
        );

        $response->assertOk();

        $expectedData['id'] = $user->id;
        $this->assertDatabaseHas(
            'users',
            $expectedData
        );
    }
}
