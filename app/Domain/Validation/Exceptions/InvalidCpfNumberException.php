<?php

namespace App\Domain\Validation\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class InvalidCpfNumberException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            Lang::get('validation.custom.cpf.invalid')
        );
    }
}
