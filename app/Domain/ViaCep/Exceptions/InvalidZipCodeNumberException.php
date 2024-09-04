<?php

use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Facades\Lang;

class InvalidZipCodeNumberException extends Handler
{
    public function render($request, Throwable $e)
    {
        return response()->json(
            [
                'errors' => [
                    Lang::get('validation.custom.zip_code.invalid')
                ]
            ],
            422
        );
    }
}
