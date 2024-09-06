<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTO\UserFormParameters;
use App\Domain\User\Models\User;

class UpdateUser
{
    public function __construct(
        private User $model
    ) {
    }

    public function execute(UserFormParameters $parameters): bool
    {
        $fields = array_filter(
            $parameters->toArray(),
            fn ($value) => $value !== null
        );

        return $this->model
            ->whereId($parameters->getId())
            ->update($fields);
    }
}
