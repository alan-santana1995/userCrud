<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTO\UpdateUserParameters;
use App\Models\User;

class UpdateUser
{
    public function __construct(
        private User $model
    ) {
    }

    public function execute(UpdateUserParameters $parameters): bool
    {
        return $this->model
            ->whereId($parameters->getId())
            ->update(
                $parameters->toArray()
            );
    }
}
