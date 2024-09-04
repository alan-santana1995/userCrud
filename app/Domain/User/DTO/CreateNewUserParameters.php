<?php

namespace App\Domain\User\DTO;

use App\Domain\User\DTO\UserFormParameters;
use App\Http\Requests\UserFormRequest;

class CreateNewUserParameters extends UserFormParameters
{
    public static function fromRequest(UserFormRequest $request): self
    {
        $data = $request->validated();

        return new self(
            name: $data['name'],
            lastName: $data['last_name'],
            email: $data['email'],
            document: $data['document'],
            birthDate: $data['birth_date'],
            phoneNumber: $data['phone_number'],
            zipCode: $data['zip_code'],
            uf: $data['uf'],
            city: $data['city'],
            neighborhood: $data['neighborhood'],
            address: $data['address'],
        );
    }
}
