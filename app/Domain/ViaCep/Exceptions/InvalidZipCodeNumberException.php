<?php

namespace App\Domain\ViaCep\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class InvalidZipCodeNumberException extends Exception
{
    public function render()
    {
        return response()->json(
            [
                'message' => Lang::get('validation.custom.zip_code.invalid'),
                'errors' => [
                    'zip_code.invalid' => Lang::get('validation.custom.zip_code.invalid')
                ]
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
