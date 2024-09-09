<?php

namespace Tests\Traits;

use App\Domain\ViaCep\DTO\ViaCepZipCodeInformation;
use Illuminate\Support\Facades\Http;

trait ViaCepMock
{
    protected function getSuccessMockFileName(): string
    {
        return 'via_cep_success.json';
    }

    protected function getErrorMockFileName(): string
    {
        return 'via_cep_error.json';
    }

    protected function mockViaCep(): void
    {
        $mockData = file_get_contents(
            $this->getViaCepMockFile($this->getSuccessMockFileName())
        );

        $this->fakeHttp($mockData);
    }

    protected function mockViaCepError(): void
    {
        $mockData = file_get_contents(
            $this->getViaCepMockFile($this->getErrorMockFileName())
        );

        $this->fakeHttp($mockData);
    }

    private function fakeHttp(string $mockData)
    {
        Http::fake(
            fn () => json_decode(
                $mockData,
                true
            )
        );
    }

    protected function getViaCepMockData(): ViaCepZipCodeInformation
    {
        return ViaCepZipCodeInformation::fromArray(
            json_decode(
                file_get_contents(
                    $this->getViaCepMockFile($this->getSuccessMockFileName())
                ),
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
