<?php

namespace Tests\Feature\User;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Lang;
use Tests\Traits\ViaCepMock;

class CreateNewUsersTest extends UsersTestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;
    use ViaCepMock;

    /**
     * Testa a criação de novos usuários.
     * CPF obtido do site: https://www.4devs.com.br/gerador_de_cpf
     * CEP da Praça da Sé
     */
    public function test_create_new_users(): void
    {
        $this->mockViaCep();
        $viaCepMockData = $this->getViaCepSuccessMockData();

        $user = User::factory()->make(
            [
                'document' => '70075640031',
                'zip_code' => "01001000",
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

        $expectedData = array_merge(
            $expectedData,
            [
                'id' => $response->offsetGet('id'),
                'status' => true,
                'address' => $viaCepMockData->getEndereco()
            ]
        );

        $this->assertDatabaseHas(
            'users',
            $expectedData
        );
    }

    /**
     * Testa a validação de cep ao criar um novo usuário.
     */
    public function test_create_new_user_with_wrong_zip_code(): void
    {
        $this->mockViaCepError();

        $user = User::factory()->make(
            [
                'document' => '70075640031',
                'zip_code' => "91919191",
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

        $response->assertUnprocessable()
            ->assertJsonFragment(
                [
                    'message' => Lang::get('validation.custom.zip_code.invalid'),
                    'errors' => [
                        'zip_code.invalid' => Lang::get('validation.custom.zip_code.invalid')
                    ]
                ]
            );
    }
}
