<?php

namespace App\Http\Domain\User\Actions;

use App\Http\Domain\User\DTO\UpdateUserParameters;
use App\Models\User;

class UpdateUser
{
    public function __construct(
        private GetUserFromId $getUserFromId
    ) {
    }

    public function execute(UpdateUserParameters $parameters): User
    {
        $user = $this->getUserFromId->execute($parameters->getId());

        $user->fill($parameters->toArray());

        return $user;
    }
}
