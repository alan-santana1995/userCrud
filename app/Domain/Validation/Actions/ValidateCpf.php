<?php

namespace App\Domain\Validation\Actions;

use App\Domain\Validation\Exceptions\InvalidCpfNumberException;

class ValidateCpf
{
    public function execute(string $cpf): void
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        throw_if(
            strlen($cpf) != 11,
            InvalidCpfNumberException::class
        );

        $this->validateDigit(
            cpf: $cpf,
            weightStartingValue: 10,
            validationDigitIndex: 9
        );

        $this->validateDigit(
            cpf: $cpf,
            weightStartingValue: 11,
            validationDigitIndex: 10
        );
    }

    private function validateDigit(
        string $cpf,
        int $weightStartingValue,
        int $validationDigitIndex
    ) {
        $sum = 0;
        for ($weight = $weightStartingValue, $i = 0; $weight >= 2;$i++,$weight--) {
            $sum += $cpf[$i] * $weight;
        }

        $rest = $sum % 11;
        $secondValidationDigit = 0;
        if ($rest >= 2) {
            $secondValidationDigit = 11 - $rest;
        }

        throw_if(
            $cpf[$validationDigitIndex] != $secondValidationDigit,
            InvalidCpfNumberException::class
        );
    }
}
