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

        $sum = 0;
        for ($weight = 10, $i = 0; $weight >= 2;$i++,$weight--) {
            $sum += $cpf[$i] * $weight;
        }

        $rest = $sum % 11;
        $firstValidationDigit = 0;
        if ($rest >= 2) {
            $firstValidationDigit = 11 - $rest;
        }

        throw_if(
            $cpf[9] != $firstValidationDigit,
            InvalidCpfNumberException::class
        );

        $sum = 0;
        for ($weight = 11, $i = 0; $weight >= 2;$i++,$weight--) {
            $sum += $cpf[$i] * $weight;
        }

        $rest = $sum % 11;
        $secondValidationDigit = 0;
        if ($rest >= 2) {
            $secondValidationDigit = 11 - $rest;
        }

        throw_if(
            $cpf[10] != $secondValidationDigit,
            InvalidCpfNumberException::class
        );
    }
}
