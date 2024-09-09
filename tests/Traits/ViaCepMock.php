<?php

namespace Tests\Traits;

use App\Domain\ViaCep\DTO\ViaCepZipCodeInformation;
use Illuminate\Support\Facades\Http;

trait ViaCepMock
{
    protected function mockViaCep(): void
    {
        $mockData = $this->getViaCepMockData('via_cep_success.json');
        Http::fake(
            [
                env('VIA_CEP_API_URL') => $mockData
            ]
        );
    }

    protected function mockViaCepError(): void
    {
        $mockData = $this->getViaCepMockFile('via_cep_error.json');
        Http::fake(
            [
                env('VIA_CEP_API_URL') => json_decode(
                    $mockData,
                    true
                )
            ]
        );
    }

    protected function getViaCepMockData(string $fileName): ViaCepZipCodeInformation
    {
        return ViaCepZipCodeInformation::fromArray(
            json_decode(
                file_get_contents($this->getViaCepMockFile($fileName)),
                true
            )
        );
    }

    protected function getViaCepMockFile(string $fileName): string
    {
        return base_path(
            'tests' . DIRECTORY_SEPARATOR .'mocks' . DIRECTORY_SEPARATOR . $fileName
        );
    }
}
