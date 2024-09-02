<?php

namespace App\Http\Requests;

class UpdateUserRequest extends UserFormRequest
{
    protected function prepareForValidation()
    {
        $this->merge(
            [
                'id' => $this->route('user')
            ]
        );
    }
}
