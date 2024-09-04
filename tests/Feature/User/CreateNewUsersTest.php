<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CreateNewUsersTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * Testa a criação de novos usuários.
     * CPF obtido do site: https://www.4devs.com.br/gerador_de_cpf
     */
    public function test_create_new_users(): void
    {
        $user = User::factory()->make(['document' => '70075640031']);
        $expectedData = [
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'document' => $user->document,
            'birth_date' => $user->birth_date,
            'phone_number' => $user->phone_number,
            'zip_code' => $user->zip_code,
            'uf' => $user->uf,
            'city' => $user->city,
            'neighborhood' => $user->neighborhood,
            'address' => $user->address,
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
