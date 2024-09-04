<?php

namespace App\Domain\User\Rules;

use App\Domain\Validation\Actions\ValidateCpf;
use App\Domain\Validation\Exceptions\InvalidCpfNumberException;
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
        try {
            app(ValidateCpf::class)->execute($value);
        } catch (InvalidCpfNumberException $e) {
            $fail($e->getMessage());
        }
    }
}
