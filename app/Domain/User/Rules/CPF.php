<?php

namespace App\Domain\User\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CPF implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = preg_replace('/\D/', '', $value);

        if (strlen($value) != 11) {
            $fail();
        }

        $digitoValidador = 0;
        for ($peso = 10, $i = 0; $peso >= 2;$i++,$peso--) {
            $digitoValidador += $value[$i] * $peso;
        }

        if ($value[9] != ((($digitoValidador %= 11) < 2) ? 0 : 11 - $digitoValidador)) {
            $fail();
        }

        $digitoValidador = 0;
        for ($peso = 11, $i = 0; $peso >= 2;$i++,$peso--) {
            $digitoValidador += $value[$i] * $peso;
        }

        if ($value[10] != ((($digitoValidador %= 11) < 2) ? 0 : 11 - $digitoValidador)) {
            $fail();
        }
    }
}
