<?php

namespace Tests\Feature\User;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Tests\Traits\ViaCepMock;

class UpdateUsersTest extends UsersTestCase
{
    use WithFaker;
    use ViaCepMock;

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

    /**
     * Testa disabilitar um usuário
     */
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

    /**
     * Testa a validação de cep ao editar um usuário.
     */
    public function test_update_user_with_wrong_zip_code(): void
    {
        $this->mockViaCepError();

        $user = User::factory()->create();
        $expectedData = [
            'zip_code' => "91919191",
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
