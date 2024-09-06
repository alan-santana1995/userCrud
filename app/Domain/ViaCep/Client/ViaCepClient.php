<?php

namespace App\Domain\ViaCep\Client;

use App\Domain\ViaCep\DTO\ViaCepZipCodeInformation;
use App\Domain\ViaCep\Exceptions\InvalidZipCodeNumberException;
use Illuminate\Support\Facades\Http;

class ViaCepClient
{
    public function get($zipCode): ViaCepZipCodeInformation
    {
        $response = Http::get(
            env('VIA_CEP_API_URL') . "/$zipCode/json"
        );

        $data = json_decode($response->getBody(), true);

        $hasError = $data['erro'] ?? false;
        throw_if(
            filter_var($hasError, FILTER_VALIDATE_BOOL),
            InvalidZipCodeNumberException::class
        );

        return ViaCepZipCodeInformation::fromArray($data);
    }
}
