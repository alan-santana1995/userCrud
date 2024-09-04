<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTO\UserFormParameters;
use App\Models\User;

class CreateNewUser
{
    public function execute(UserFormParameters $parameters): int
    {
        $user = new User($parameters->toArray());

        $user->save();

        return $user->id;
    }
}
