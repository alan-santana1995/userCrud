<?php

use App\Http\Domain\User\DTO\UserFormParameters;
use App\Http\Requests\UserFormRequest;

class CreateNewUserParameters extends UserFormParameters
{
    public static function fromRequest(UserFormRequest $request): self
    {
        $data = $request->validated();

        return new self(
            name: $data['name'],
            email: $data['email'],
            document: $data['document'],
            birthDate: $data['birthDate'],
            phoneNumber: $data['phoneNumber'],
            zipCode: $data['zipCode'],
            uf: $data['uf'],
            city: $data['city'],
            neighborhood: $data['neighborhood'],
            address: $data['address'],
        );
    }
}
