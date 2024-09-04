<?php

namespace Tests\Feature\User;

use App\Domain\ViaCep\DTO\ViaCepZipCodeInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UsersTestCase extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    protected function mockViaCep(): void
    {
        $mockDataPath = base_path(
            'tests' . DIRECTORY_SEPARATOR .'mocks' . DIRECTORY_SEPARATOR .'via_cep_success.json'
        );
        $mockData = ViaCepZipCodeInformation::fromArray(
            json_decode(
                file_get_contents($mockDataPath),
                true
            )
        );
        Http::fake(
            [
                env('VIA_CEP_API_URL') => $mockData
            ]
        );
    }
}
