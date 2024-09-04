<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTO\CreateNewUserParameters;
use App\Models\User;

class CreateNewUser
{
    public function execute(CreateNewUserParameters $parameters): int
    {
        $user = new User($parameters->toArray());

        $user->save();

        return $user->id;
    }
}
