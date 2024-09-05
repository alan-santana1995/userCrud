<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateNewUsersTest extends UsersTestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * Testa a criação de novos usuários.
     * CPF obtido do site: https://www.4devs.com.br/gerador_de_cpf
     * CEP da Av. Paulista
     */
    public function test_create_new_users(): void
    {
        $this->mockViaCep();

        $user = User::factory()->make(
            [
                'document' => '70075640031',
                'zip_code' => "01310930"
            ]
        );
        $expectedData = [
            'name' => $user->name,
            'email' => $user->email,
            'document' => $user->document,
            'birth_date' => $user->birth_date,
            'phone_number' => $user->phone_number,
            'zip_code' => $user->zip_code,
        ];

        $response = $this->postJson(
            route('users.store'),
            $expectedData
        );

        $response->assertOk()
            ->assertJsonStructure(['id']);

        $expectedData['status'] = true;
        $this->assertDatabaseHas(
            'users',
            $expectedData
        );
    }
}
